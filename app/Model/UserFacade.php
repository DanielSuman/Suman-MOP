<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\Passwords;


/**
 * Manages user-related operations such as authentication and adding new users.
 */
final class UserFacade implements Nette\Security\Authenticator
{
	// Minimum password length requirement for users
	public const PasswordMinLength = 7;

	// Database table and column names
	private const
		TableName = 'users',
		ColumnId = 'id',
		ColumnName = 'username',
		ColumnPasswordHash = 'password',
		ColumnEmail = 'email',
		ColumnRole = 'role',
		ColumnNickname = 'nickname',
		ColumnFirstname = 'firstname',
		ColumnMiddlename = 'middlename',
		ColumnLastname = 'lastname',
		ColumnPhone = 'phone',
		ColumnCountry = 'country',
		ColumnRegion = 'region',
		ColumnCity = 'city',
		ColumnStreet = 'street',
		ColumnZipcode = 'zipcode';

	// Dependency injection of database explorer and password utilities
	public function __construct(
		private Nette\Database\Explorer $database,
		private Passwords $passwords,
	) {
	}


	/**
	 * Authenticate a user based on provided credentials.
	 * Throws an AuthenticationException if authentication fails.
	 */
	public function authenticate(string $username, string $password): Nette\Security\SimpleIdentity
	{
		// Fetch the user details from the database by username
		$row = $this->database->table(self::TableName)
			->where(self::ColumnName, $username)
			->fetch();

		// Authentication checks
		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IdentityNotFound);
		} elseif (!$this->passwords->verify($password, $row[self::ColumnPasswordHash])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::InvalidCredential);
		} elseif ($this->passwords->needsRehash($row[self::ColumnPasswordHash])) {
			$row->update([
				self::ColumnPasswordHash => $this->passwords->hash($password),
			]);
		}

		// Return user identity without the password hash
		$arr = $row->toArray();
		unset($arr[self::ColumnPasswordHash]);
		return new Nette\Security\SimpleIdentity($row[self::ColumnId], $row[self::ColumnRole], $arr);
	}


	/**
	 * Add a new user to the database.
	 * Throws a DuplicateNameException if the username is already taken.
	 */
	public function add(
		string $username,
		string $email,
		string $password,
		string $nickname,
		string $firstname,
		string $middlename,
		string $lastname,
		string $phone,
		string $country,
		string $region,
		string $city,
		string $street,
		string $zipcode,
		string $role
	): void {
		// Validate the email format
		Nette\Utils\Validators::assert($email, 'email');

		// Attempt to insert the new user into the database
		try {
			$this->database->table(self::TableName)->insert([
				self::ColumnName => $username,
				self::ColumnEmail => $email,
				self::ColumnPasswordHash => $this->passwords->hash($password),
				self::ColumnNickname => $nickname,
				self::ColumnFirstname => $firstname,
				self::ColumnMiddlename => $middlename,
				self::ColumnLastname => $lastname,
				self::ColumnPhone => $phone,
				self::ColumnCountry => $country,
				self::ColumnRegion => $region,
				self::ColumnCity => $city,
				self::ColumnStreet => $street,
				self::ColumnZipcode => $zipcode,
				self::ColumnRole => $role,
			]);
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

	public function getUserById(int $id)
	{
		$user = $this->database
			->table('users')
			->get($id);
		return $user;
	}

	public function getAll()
	{
		return $this->database->table('users')->fetchAll();
	}

	public function insertUser($data)
	{
		$user = $this->database
			->table('users')
			->insert($data);

		return $user;
	}

	public function editUser($id, $data)
	{
		$user = $this->database->table('users')->get($id);
	
		// Check if the user exists
		if (!$user) {
			throw new \Exception('User not found');
		}
	
		// Check if the password needs to be hashed and updated
		if (!empty($data['password'])) {
			$data[self::ColumnPasswordHash] = $this->hashPassword($data['password']);
		} else {
			unset($data[self::ColumnPasswordHash]); // Do not update password if not provided
		}
	
		// Update user data
		$user->update($data);
		return $user;
	}


	public function deleteUser($id)
	{
		$user = $this->database
			->table('users')
			->get($id);

		if ($user) {
			$user->delete();
			return true; // Return true to indicate successful deletion
		}

		return false; // Return false if the mod was not found
	}

	public function hashPassword(string $password): string
	{
		return $this->passwords->hash($password);
	}
}


/**
 * Custom exception for duplicate usernames.
 */
class DuplicateNameException extends \Exception
{
}
