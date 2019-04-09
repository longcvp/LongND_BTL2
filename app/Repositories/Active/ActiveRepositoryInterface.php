<?php
namespace App\Repositories\Active;

interface ActiveRepositoryInterface
{
	public function getUserByToken($token);

	public function deleteToken($token);

}