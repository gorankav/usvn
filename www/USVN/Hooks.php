<?php
/**
 * Class who handle subversion hooks
 *
 * @author Team USVN <contact@usvn.info>
 * @link http://www.usvn.info
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2-en.txt CeCILL V2
 * @copyright Copyright 2007, Team USVN
 * @since 0.8
 * @package svnhooks
 * @subpackage model
 *
 * This software has been written at EPITECH <http://www.epitech.net>
 * EPITECH, European Institute of Technology, Paris - FRANCE -
 * This project has been realised as part of
 * end of studies project.
 *
 * $Id$
 */
class USVN_Hooks
{
	/**
	* Start commit hook
	*
	* @param string Project name
	* @param string The user login
	* @return string or 0 String if error in commit, 0 if it's OK
	*/
	public function startCommit($project, $user)
	{
		return 0;
	}

	/**
	* Pre commit hook
	*
	* @param string Project name
	* @param string The user login
	* @param string Log message
	* @param array List of changed files and here status (exemple: array(array('U', 'test'), array('A', 'toto')))
	* @return string or 0 String if error in commit, 0 if it's OK
	*/
	public function preCommit($project, $user, $log, $changedfiles)
	{
		return 0;
	}

	/**
	* Post commit hook
	*
	* @param string Project name
	* @param integer Revision number
	* @param string The user login
	* @param string Log message
	* @param array List of changed files and here status (exemple: array(array('U', 'test'), array('A', 'toto')))
	*/
	public function postCommit($project, $revision, $user, $log, $changedfiles)
	{
	}

	/**
	* Pre lock hook
	*
	* @param string Project name
	* @param string Path
	* @param string The user login
	* @return string or 0 String if error in lock, 0 if it's OK
	*/
	public function preLock($project, $path, $user)
	{
		return 0;
	}

	/**
	* Post lock hook
	*
	* @param string Project name

	* @param string Path
	* @param string The user login
	*/
	public function postLock($project, $path, $user)
	{
	}

	/**
	* Pre unlock hook
	*
	* @param string Project name
	* @param string Path
	* @param string The user login
	* @return string or 0 String if error in lock, 0 if it's OK
	*/
	public function preUnlock($project, $path, $user)
	{
		return 0;
	}

	/**
	* Post unlock hook
	*
	* @param string Project name
	* @param string Path
	* @param string The user login
	*/
	public function postUnlock($project, $path, $user)
	{
	}

	/**
	* Pre revprop change hook
	*
	* @param string Project name
	* @param integer Revision
	* @param string The user login
	* @param string Property will be change (ex: svn:log)
	* @param string Action (ex: M)
	* @param string New property value
	* @return string or 0 String if error in property change, 0 if it's OK
	*/
	public function preRevpropChange($project, $revision, $user, $property, $action, $value)
	{
		return 0;
	}

	/**
	* Pre revprop change hook
	*
	* @param string Project name
	* @param integer Revision
	* @param string The user login
	* @param string Property will be change (ex: svn:log)
	* @param string Action (ex: M)
	* @param string Old property value
	*/
	public function postRevpropChange($project, $revision, $user, $property, $action, $value)
	{
	}

	/**
	* Use by client to check if he speak to a valid  USVN server
	*
	* @param string Project name
	* @return or 0 String if error, 0 if it's OK
	*/
	public function validUSVNServer($project)
	{
		return 0;
	}
}
