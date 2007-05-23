<?php
/**
 * Class to test user's model
 *
 * @author Team USVN <contact@usvn.info>
 * @link http://www.usvn.info
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2-en.txt CeCILL V2
 * @copyright Copyright 2007, Team USVN
 * @since 0.5
 * @package Db
 * @subpackage Table
 *
 * This software has been written at EPITECH <http://www.epitech.net>
 * EPITECH, European Institute of Technology, Paris - FRANCE -
 * This project has been realised as part of
 * end of studies project.
 *
 * $Id$
 */

// Call USVN_Auth_Adapter_DbTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "USVN_Db_Table_UsersTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'www/USVN/autoload.php';

/**
 * Test class for USVN_Auth_Adapter_Db.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-25 at 09:51:30.
 */
class USVN_Db_Table_UsersTest extends USVN_Test_DB {

    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("USVN_Db_Table_UsersTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp() {
		parent::setUp();

    }

	public function giveConfig() {
		$configArray = array('subversion' => array('path' => 'tests/tmp/'));
		$config = new Zend_Config($configArray);
		Zend_Registry::set('config', $config);
	}

    public function testUserInsertNoLogin()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> '',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Login empty', $e->getMessage());
			return;
		}
		$this->fail();
	}

    public function testUserInsertInvalidEmailAddress()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'InsertInvalidEmailAddress',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'BadEmail'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Invalid email address', $e->getMessage());
			$this->assertFalse($table->isAUser('InsertInvalidEmailAddress'));
			return;
		}
		$this->fail();
    }

    public function testUserInsertNoPassword()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'InsertNoPassword',
									'users_password' 	=> '',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Password empty', $e->getMessage());
			$this->assertFalse($table->isAUser('InsertNoPassword'));
			return;
		}
		$this->fail();
    }

    public function testUserInsertNoPassword2()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'InsertNoPassword2',
									'users_password' 	=> "   \t   ",
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Password empty', $e->getMessage());
			$this->assertFalse($table->isAUser('InsertNoPassword2'));
			return;
		}
		$this->fail();
    }

    public function testUserInsertInvalidPassword()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'InsertNoPassword',
									'users_password' 	=> 'badPass',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Password incorrect', $e->getMessage());
			$this->assertFalse($table->isAUser('InsertNoPassword'));
			return;
		}
		$this->fail();
    }

    public function testUserInsertOk()
    {
		$this->giveConfig();
    	$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'InsertOk',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		$obj->save();
		$this->assertTrue($table->isAUser('InsertOk'));
    }

    public function testUserUpdateNoLogin()
	{
		$this->giveConfig();
    	$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'InsertOkUpdateNoLogin',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		$id = $obj->save();
		$obj = $table->find($id)->current();
		$obj->setFromArray(array('users_login' 			=> '',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Login empty', $e->getMessage());
			return;
		}
		$this->assertTrue($table->isAUser('InsertOkUpdateNoLogin'));
    }

    public function testUserUpdateInvalidEmailAddress()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'UpdateInvalidEmailAddress',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		$id = $obj->save();
		$obj = $table->find($id)->current();
		$obj->setFromArray(array('users_login' 			=> 'UpdateInvalidEmailAddress',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'badEmail'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Invalid email address', $e->getMessage());
			return;
		}
		$user = $table->fetchRow(array('users_login = ?' => 'UpdateInvalidEmailAddress'));
		$this->assertEquals($user->password, crypt('password', $user->password));
    }

    public function testUserUpdateNoPassword()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'UpdateNoPassword',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		$id = $obj->save();
		$obj = $table->find($id)->current();
		$obj->setFromArray(array('users_login' 			=> 'UpdateNoPassword',
									'users_password' 	=> '',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Password empty', $e->getMessage());
			return;
		}
		$user = $table->fetchRow(array('users_login = ?' => 'UpdateNoPassword'));
		$this->assertEquals($user->password, crypt('password', $user->password));
    }

    public function testUserUpdateInvalidPassword()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'UpdateInvalidPassword',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		$id = $obj->save();
		$obj = $table->find($id)->current();
		$obj->setFromArray(array('users_login' 			=> 'UpdateInvalidPassword',
									'users_password' 	=> 'badPass',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		try {
			$obj->save();
		}
		catch (USVN_Exception $e) {
			$this->assertContains('Password incorrect', $e->getMessage());
			return;
		}
		$user = $table->fetchRow(array('users_login = ?' => 'UpdateInvalidPassword'));
		$this->assertEquals($user->password, crypt('password', $user->password));
    }

    public function testUserUpdateOk()
    {
		$this->giveConfig();
    	$table = new USVN_Db_Table_Users();
		$obj = $table->fetchNew();
		$obj->setFromArray(array('users_login' 			=> 'UpdateOk',
									'users_password' 	=> 'password',
									'users_firstname' 	=> 'firstname',
									'users_lastname' 	=> 'lastname',
									'users_email' 		=> 'email@email.fr'));
		$id = $obj->save();
		$obj = $table->find($id)->current();
		$obj->setFromArray(array('users_login' 			=> 'newUpdateOk',
									'users_password' 	=> 'newPassword',
									'users_firstname' 	=> 'newFirstname',
									'users_lastname' 	=> 'newLastname',
									'users_email' 		=> 'newemail@email.fr'));
		$obj->save();
		$this->assertFalse($table->isAUser('UpdateOk'));
		$this->assertTrue($table->isAUser('newUpdateOk'));
    }

	public function testUserUpdateHtpasswd()
	{
		$this->giveConfig();
		$table = new USVN_Db_Table_Users();

		$table->insert(array('users_login' 			=> 'Toto',
								 'users_password' 	=> 'titititi',
								 'users_firstname' 	=> 'firstname',
								 'users_lastname' 	=> 'lastname',
								 'users_email' 		=> 'email@email.fr'));

		$table->updateHtpasswd();
		$text = "Toto:titititi\n";
		$contenu = file_get_contents(Zend_Registry::get('config')->subversion->path."htpasswd");
		$this->assertEquals($text, $contenu);
	}

	public function testUserUpdateHtpasswdBadPath()
	{
		$configArray = array('subversion' => array('path' => 'titi/'));
		$config = new Zend_Config($configArray);
		Zend_Registry::set('config', $config);
		try	{
			$table = new USVN_Db_Table_Users();
			$table->updateHtpasswd();
		}
		catch (USVN_Exception $e) {
			return;
		}
		$this->fail();
	}
}

if (PHPUnit_MAIN_METHOD == "USVN_Db_Table_UsersTest::main") {
    USVN_Db_Table_UsersTest::main();
}
?>
