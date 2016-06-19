<?php

class Register_test extends TestCase{

	public function test_register_professor(){
		$output = $this->request(
            'POST',
            ['Guest', 'register'],
            [
                'email' => 'test_prof@yahoo.com',
								'username' => 'testprof',
								'password' => 'stevanbr1',
								'passconf' => 'stevanbr1',
								'reg_who' => 'p'
            ]
        );
		$this->assertContains('Register Success', $output);
		$output = $this->request(
            'POST',
            ['Guest', 'login'],
            [
                'login_username' => 'testprof',
								'login_password' => 'stevanbr1'
            ]
        );
		$this->assertRedirect('professor', 302);
	}

	public function test_register_student(){
		$output = $this->request(
            'POST',
            ['Guest', 'register'],
            [
                'email' => 'test_student@yahoo.com',
								'username' => 'teststudent',
								'password' => 'stevanbr1',
								'passconf' => 'stevanbr1',
								'reg_who' => 'e'
            ]
        );
		$this->assertContains('Register Success', $output);
		$output = $this->request(
            'POST',
            ['Guest', 'login'],
            [
                'login_username' => 'teststudent',
								'login_password' => 'stevanbr1'
            ]
        );
		$this->assertRedirect('student', 302);
	}
}
