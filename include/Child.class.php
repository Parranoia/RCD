<?php

class Child
{
	private $name;
	private $dob;
	private $gender;
	
	public function __construct($name, $dob, $gender)
	{
		$this->name = $name;
		$this->dob = $dob;
		$this->gender = $gender;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getDob()
	{
		return $this->dob;
	}
	
	public function getGender()
	{
		return $this->gender;
	}
}

?>