<?php

include_once "pm_common.php";
//<TODO> Testing of all functions

/*
    bcadd — Add two arbitrary precision numbers
    bccomp — Compare two arbitrary precision numbers
    bcdiv — Divide two arbitrary precision numbers
    bcmod — Get modulus of an arbitrary precision number
    bcmul — Multiply two arbitrary precision numbers
    bcpow — Raise an arbitrary precision number to another
    bcpowmod — Raise an arbitrary precision number to another, reduced by a specified modulus
    bcscale — Set default scale parameter for all bc math functions
    bcsqrt — Get the square root of an arbitrary precision number
    bcsub — Subtract one arbitrary precision number from another
*/
	
class RealNumber
{
	private $n="0";
	private $d="1";
	
	//Assumption: sign is always carried by the numerator.
	public function __construct($n="0",$d="1",$dontReduce=false)
	{
		$this->n=$n;
		$this->d=$d;
		if(!$dontReduce) selfReduce();
	}	
	
	private function reduce()
	{
		$a=$this->n;
		$b=$this->d;
		$hcf=hcf($a,$b);
		$a=bcdiv($a,$hcf);
		$b=bcdiv($a,$hcf);
		return new RealNumber($a,$b,true);
	}
	
	public function selfReduce()
	{
		$hcf=hcf($this->n,$this->d);
		$this->n=bcdiv($this->n,$hcf);
		$this->d=bcdiv($this->d,$hcf);
		return $this;
	}
	
	public function __toString()
	{
		return bcdiv($n,$d);
	}
	
	public function getN()
	{
		return $n;
	}
	
	public function getD()
	{
		return $d;
	}
	
	public function plus($r)	//$r is RealNumber
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->n;
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=bcdiv($d2,$hcf);
		$n=bcadd(bcmul($n1,$f),bcmul($n2,bcdiv($d1,$hcf)));
		$d=bcmul($f,$d1);
		reduce2($n,$d);
		return new RealNumber($n,$d,true);
	}
	
	public function minus($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=bcmul($r->n,"-1");
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=bcdiv($d2,$hcf);
		$n=bcadd(bcmul($n1,$f),bcmul($n2,bcdiv($d1,$hcf)));
		$d=bcmul($f,$d1); 
		reduce2($n,$d);
		return new RealNumber($n,$d,true);
	}
	
	//Assumption: $r and $this are already reduced.
	public function multiply($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->n;
		$d2=$r->d;
		reduce2($n1,$d2);
		reduce2($n2,$d1);
		return new RealNumber(bcmul($n1,$n2),bcmul($d1,$d2),true);
	}

	public function divide($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->d;
		$d2=$r->n;
		if(bccomp($d2,"0")==-1) 
		{
			$d2=bcmul($d2,"-1");
			$n2=bcmul($n2,"-1");
		}
		reduce2($n1,$d2);
		reduce2($n2,$d1);
		return new RealNumber(bcmul($n1,$n2),bcmul($d1,$d2),true);
	}
	
	public function inverse()
	{
		if(bccomp($this->n,"0")==-1) return new RealNumber(bcmul($this->d,"-1"),bcmul($this->n,"-1"),true);
		return new RealNumber($this->d,$this->n,true);
	}
	
	public function selfPlus($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->n;
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=bcdiv($d2,$hcf);
		$this->n=bcadd(bcmul($n1,$f),bcmul($n2,bcdiv($d1,$hcf)));
		$this->d=bcmul($f,$d1);
		selfReduce();
		return $this;		
	}
	
	public function selfMinus($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=bcmul($r->n,"-1");
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=bcdiv($d2,$hcf);
		$this->n=bcadd(bcmul($n1,$f),bcmul($n2,bcdiv($d1,$hcf)));
		$this->d=bcmul($f,$d1); 
		selfReduce();
		return $this;		
	}
	
	public function selfMultiply($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->n;
		$d2=$r->d;
		reduce2($n1,$d2);
		reduce2($n2,$d1);
		$this->n=bcmul($n1,$n2);
		$this->d=bcmul($d1,$d2);
		return $this;
	}
	
	public function selfDivide($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->d;
		$d2=$r->n;
		if(bccomp($d2,"0")==-1) 
		{
			$d2=bcmul($d2,"-1");
			$n2=bcmul($n2,"-1");
		}
		reduce2($n1,$d2);
		reduce2($n2,$d1);
		$this->n=bcmul($n1,$n2);
		$this->d=bcmul($d1,$d2);
		return $this;
	}
	
	public function selfInverse()
	{
		if(bccomp($this->n,"0")==-1)
		{
			$this->n=bcmul($this->n,"-1");
			$this->d=bcmul($this->d,"-1");
		} 
		swap($this->n,$this->d);
		return $this;
	}
}


function hcf($a,$b)
{
	if(bccomp(bcmod($a,$b),"0")==0) return $b;
	return hcf($b,bcmod($a,$b));
}

function lcm($a,$b)
{
	$hcf=hcf($a,$b);
	reduce2($a,$hcf); 
	return bcmul($a,$b);
}

function reduce1($a,$b)
{
	$hcf=hcf($a,$b);
	return Array(bcdiv($a,$hcf),bcdiv($b,$hcf));
}

function reduce2(&$a,&$b)
{
	$hcf=hcf($a,$b);
	$a=bcdiv($a,$hcf);
	$b=bcdiv($b,$hcf);	
}

function bcmin($a,$b,$c)
{
	if(bccomp($a,$b,$c)<0) return $a;
	return $b;
}

function bcmax($a,$b,$c)
{
	if(bccomp($a,$b,$c)>0) return $a;
	return $b;
}
?>