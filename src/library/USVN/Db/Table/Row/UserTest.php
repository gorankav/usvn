<?php
// Call USVN_Db_Table_Row_GroupTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "USVN_Db_Table_Row_UserTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'library/USVN/autoload.php';
define('CONFIG_FILE', './tests/tmp/config.ini');


/**
 * Test class for USVN_Db_Table_Row_Group.
 * Generated by PHPUnit_Util_Skeleton on 2007-04-18 at 14:39:49.
 */
class USVN_Db_Table_Row_UserTest extends USVN_Test_DB {
	private $userTable;
	private $user;
	private $userid;
	private $groups;

	/**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("USVN_Db_Table_Row_UserTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp() {
		parent::setUp();
		$this->userTable = new USVN_Db_Table_Users();
		$this->user = $this->userTable->fetchNew();
		$this->user->users_login = 'test';
		$this->user->users_password = USVN_Crypt::crypt("test");
		$this->userid = $this->user->save();

		$this->groups = new USVN_Db_Table_Groups();
		$group = $this->groups->insert(
			array(
				"groups_id" => 42,
				"groups_name" => "test",
				"groups_description" => "test"
			)
		);
		$this->groups->insert(
			array(
				"groups_id" => 43,
				"groups_name" => "test2",
				"groups_description" => "test2"
			)
		);
		$this->groups->insert(
			array(
				"groups_id" => 44,
				"groups_name" => "test3",
				"groups_description" => "test3"
			)
		);
    }

    public function testUser()
	{
		$this->assertEquals('test', $this->user->users_login);
		$this->assertEquals('test', $this->user->login);
	}

	public function testAddGroup()
	{
		$this->user->addGroup($this->groups->find(42)->current());
		$this->user->addGroup($this->groups->find(43)->current());
		$this->groups = $this->user->listGroups();
		$res = array();
		foreach ($this->groups as $group) {
			array_push($res, $group->groups_name);
		}
		$this->assertContains("test", $res);
		$this->assertContains("test2", $res);
		$this->assertNotContains("notest", $res);
	}

	public function testDeleteGroup()
	{
		$this->user->addGroup($this->groups->find(42)->current());
		$this->user->addGroup($this->groups->find(43)->current());
		$this->user->deleteGroup($this->groups->find(42)->current());
		$this->groups = $this->user->listGroups();
		$res = array();
		foreach ($this->groups as $group) {
			array_push($res, $group->groups_name);
		}
		$this->assertNotContains("test", $res);
		$this->assertContains("test2", $res);
		$this->assertNotContains("notest", $res);
	}

	public function testDeleteAllGroup()
	{
		$this->user->addGroup($this->groups->find(42)->current());
		$this->user->addGroup($this->groups->find(43)->current());
		$this->user->deleteAllGroups();
		$this->groups = $this->user->listGroups();
		$res = array();
		foreach ($this->groups as $group) {
			array_push($res, $group->groups_name);
		}
		$this->assertNotContains("test", $res);
		$this->assertNotContains("test2", $res);
		$this->assertNotContains("notest", $res);
		$this->assertEquals(0, count($res));
	}

	public function testIsInGroup()
	{
		$group = $this->groups->find(42)->current();
		$this->assertFalse($this->user->isInGroup($group));
		$this->user->addGroup($group);
		$this->assertTrue($this->user->isInGroup($group));
	}

	public function testIsInGroupNewUser()
	{
		$group = $this->groups->find(42)->current();
		$user = $this->userTable->fetchNew();
		$this->assertFalse($user->isInGroup($group));
	}

	public function testListGroups()
	{
		$this->assertEquals(0, count($this->user->listGroups()));
		$this->user->addGroup($this->groups->find(42)->current());
		$this->user->addGroup($this->groups->find(43)->current());
		$this->assertEquals(2, count($this->user->listGroups()));
	}

	public function testGetAllGroupsFor()
	{
		$this->user->addGroup($this->groups->find(42)->current());
		$this->user->addGroup($this->groups->find(43)->current());

		$table = new USVN_Db_Table_Projects();
		$proj = $table->createRow(array("projects_name" => "proj"));
		$proj->save();
		$proj->addGroup($this->groups->find(42)->current());

		$groups_name = $this->user->getAllGroupsFor("proj");
		$groups_object = $this->user->getAllGroupsFor($proj);

		$this->assertEquals($groups_name, $groups_object, "USVN_Db_Table_Row_User::getAllGroupsFor() must act the same way with a string or an object");
	}
}

// Call USVN_Db_Table_Row_GroupTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "USVN_Db_Table_Row_UserTest::main") {
    USVN_Db_Table_Row_UserTest::main();
}
?>
