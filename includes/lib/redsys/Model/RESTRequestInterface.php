<?php

namespace es\ucm\fdi\aw\lib\redsys\Model;

	if(!interface_exists('RESTRequestInterface')){
		interface RESTRequestInterface{

			public function getTransactionType();
		}
	}