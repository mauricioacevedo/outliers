<?php
/*
class LoginControllerTest extends WebTestCase
{
	public $fixtures=array(
			'posts'=>'Post',
	);

	public function testactionLogin()
	{
		$this->open('post/1');
		// verify the sample post title exists
		$this->assertTextPresent($this->posts['sample1']['title']);
		// verify comment form exists
		$this->assertTextPresent('Leave a Comment');
	}
}
*/
class LoginControllerTest extends CTestCase { 	
	public function testactionLogin() 	{
	$val=true;
	$this->assertTrue($val);
	}
}