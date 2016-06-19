<?php

class Admin_test extends TestCase{

	public function test_admin_login(){
		$output = $this->request(
            'POST',
            ['Guest', 'login'],
            [
                'login_username' => 'admin',
								'login_password' => 'stevanbr1'
            ]
        );
		$this->assertRedirect('admin', 302);
	}

	public function test_add_cours(){
		$cours_descr = "Niveau = 1;Nom_du_Cours = Test;Visible = false;Comme ca va? Je |input-suis-etre| tres bein";
		$this->request(
            'POST',
            ['Guest', 'login'],
            [
                'login_username' => 'admin',
								'login_password' => 'stevanbr1'
            ]
        );
		$output = $this->request(
            'POST',
            ['Admin', 'submit_cours'],
            [
                'cours_descr' => $cours_descr
            ]
        );
		$this->assertResponseCode(200);
		$this->assertContains('<h1>Test</h1>', $output);
		$this->assertContains('Comme ca va? Je <input type="text" name="etre" value="" class="regular" placeholder="etre" size="5" autocomplete="off"  />', $output);
	  $this->assertContains('cours ajouté', $output);
	}
}
