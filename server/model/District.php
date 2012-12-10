<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class District extends SubClass
{
	public function city()
	{
		return new City($this->city);
	}
}
