<?php
namespace App\Repositories\User;
    
use File;
use App\Models\User;
use App\Mail\ActiveMail;
use App\Mail\ResetPassMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    public function createUser($data)
    {
        $token = $this->getToken();
        DB::transaction(function() use ($data, $token) {
            $newUser = $this->_model->saveUser($data);
            $newUser->active()->create(['active_code' => $token]);
            $newUser->infomation()->create(['name' => $data->name]);
            $this->sendActiveMail($token, $newUser);
        });
    }

    public function editUser($data)
    {
        DB::transaction(function() use ($data) {
            $user = $this->_model->find($data->id);
            $this->updateInformation($data, $user);
            $user->update(['email' => $data->email]);
        });
    }

    protected function saveImage($data)
    {
        $path = public_path().'/images/avatar';
        File::makeDirectory($path, $mode = 0777, true, true);
        $avatar = '';
        if ($data->hasFile('avatar')) {
            $images = $data->avatar;
            $imagesName = $images->getClientOriginalName();
            $new_name = time().$imagesName;
            $avatar = 'images/avatar/'.$new_name;
            $images->move($path, $avatar);
        }

        return $avatar;      
    }

    public function updateInformation($data, $user)
    {
        $oldAvatar = $user->infomation->avatar;
        $newAvatar = $this->saveImage($data);
        if ($newAvatar != '' && $oldAvatar != 'images/avatar/default.jpg') {
            $this->deleteImage($oldAvatar);
        }
        $avatar = ($newAvatar == '') ? $oldAvatar : $newAvatar;        
        $updateData = [
            'name' => $data->name,
            'address' => $data->address,
            'phone' => $data->phone,
            'gender' => $data->gender,
            'birthday' => $data->birthday,   
            'avatar' => $avatar,   
        ];

        return $user->infomation()->update($updateData);        
    }

    protected function deleteImage($img)
    {
        if(File::exists($img)) {
            return File::delete($img);
        }
    }

    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    protected function sendActiveMail($token, $newUser)
    {
        $activeLink = url('/login/'). $token;
        try{
            Mail::to($newUser->email)
                    ->send(new ActiveMail($activeLink, $newUser->name));
        }catch (Exception $e){
            throw new MailException('progress.sentMailError');
        }        
    }

    public function authLogin($id)
    {
        $user = $this->_model->find($id);
        $user->update(['active' => ACTIVE]);
    }

    public function resetPass($email)
    {
        $user = $this->_model->findUserByEmail($email);
        $password = str_random(6);
        $reset = [
            'password' => bcrypt($password),
            'reset_password' => RESET_PASS,
        ];
        $user->update($reset);
        $this->sendResetMail($password, $user);

    }

    protected function sendResetMail($password, $user)
    {
        $activeLink = url('/login/');
        try {
            Mail::to($user->email)
                  ->send(new ResetPassMail($activeLink, $user->username, $password));
        } catch (Exception $e){
            throw new MailException('progress.sentMailError');
        }        
    }

    public function changePass($id, $password)
    {

        $updateData = [
            'password' => $password,
            'reset_password' => NO_RESET_PASS,

        ];
        $this->_model->find($id)->update($updateData);        
    }
}