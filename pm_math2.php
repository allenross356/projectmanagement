<?php

include_once "pm_common.php";
//<TODO> Testing of all functions

class StringInteger
{
	private $val="0";
	private $isNegative=false;
	private $length=1;
	
	public function __construct($v) //$v is string
	{
		setValue($v)
	}
	
	private function __construct($v,$b,$r=true,$l=-1) //$v is string/number, $b is boolean/isNegative, $r is boolean/reverse, $l is integer/length
	{
		if($r)
			$this->val=strrev($v);
		else
			$this->val=$v;
		if($l==-1)
			$this->length=strlen($v);
		else
			$this->length=$l;
		$this->isNegative=$b;						
	}
	

	
	
//PUBLIC

	public copy()
	{
		return new StringInteger($this->val,$this->isNegative,false,$this->length)
	}

	public function getValue()
	{
		if($isNegative)
			return "-".strrev($isNegative);
		else
			return strrev($this->val);
	}
	
	public function setValue($v) //$v is string
	{
		if($v[0]=="-")
		{
			$this->val=strrev(substr($v,1));
			$this->length=strlen($this->val);
			$this->isNegative=true;
		}
		else
		{ 
			$this->val=strrev($v);
			$this->length=strlen($this->val);
			$this->isNegative=false;
		}
		return $v;
	}
	
	public function isNegative()
	{
		return $this->isNegative;
	}
	
	public function setNegative($v) //$v is boolean
	{
		$this->isNegative=$v;
	}
	
	public function switchNegative()
	{
		$this->isNegative=!$this->isNegative;
	}
	
	public function plus($r) //$r is StringInteger
	{
		if($this->isNegative==$r->isNegative)
		{
			$a=$this->val;
			$b=$r->val;
			$minp=$this->length;
			$maxp=$r->length;
			if($minp>$maxp)
			{
				swap($a,$b);
				swap($minp,$maxp);
			} 
			$b.="0";
			$a.="0";
			$c="0";
			for($i=0,$i<=$minp;$i++)
			{
				$d=strrev(simplePlus(simplePlus($a[$i],$b[$i]),$c));
				$b[$i]=$d[0];
				$c=pos($d,1);
			}
			if($b[$maxp]=='0') $b=substr($b,0,$maxp); else $maxp+=1;
			return new StringInteger($b,$this->isNegative,false,$maxp);
		}
		else
		{
			return minus(new StringInteger($r->val,!$r->isNegative,false));
		}
	}
		
	public function minus($r) //$r is StringInteger
	{
		if($this->isNegative==$r->isNegative)
		{
			$a=$this->val."0";
			$b=$r->val."0";
			$minp=$this->length;
			$maxp=$r->length;
			$c1=$this->isNegative;
			$c2=$r->isNegative;
			arrange($a,$b,$minp,$maxp,$c1,$c2);
			$c="0";
			$mi=-1;
			for($i=0;$i<=$minp;$i++)
			{
				$d=simpleMinus($b[$i],simplePlus($a[$i],$c));
				$c=$d[1];
				$b[$i]=$d[0];
				if($d[0]!='0') $mi=$i;
			}
			if($mi==-1)
			{
				$b="0";
				$maxp=1;
				$c2=false;
			}			
			else
			{
				$b=substr($b,0,$mi+1);
				$maxp=$mi+1;
			}
			return new StringInteger($b,$c2,false,$maxp);
		}
		else
		{
			return plus(new StringInteger($r->val,!$r->isNegative,false,$r->length));
		}
	}
	
	public function multiply($r) //$r is StringInteger
	{
		$a=$this->val;
		$b=$r->val;
		$minp=$this->length;
		$maxp=$r->length;
		if($minp>$maxp)
		{
			swap($a,$b);
			swap($minp,$maxp);
		} 
		$b.="0";
		$sum=new StringInteger("0",false,false);
		for($i=0;$i<$minp;$i++)
		{
			$br=simpleMultiply2($a[$i],$b);
			$sum=$sum->plus(new StringInteger(str_repeat("0",$i).$br[0],false,false,$br[1]+$i));
		}
		if($this->isNegative!=$r->isNegative)
			$sum->isNegative=true;
		return $sum;
	}
	
	public function divide($r) //$r is StringInteger
	{
		return divideHelper($r)[0];
	}
	
	public function remainder($r) //$r is StringInteger
	{
		return divideHelper($r)[1];		
	}
	
	public function selfPlus($r)
	{
		if($this->isNegative==$r->isNegative)
		{
			$a=$this->val;
			$b=$r->val;
			$minp=$this->length;
			$maxp=$r->length;
			if($minp>$maxp)
			{
				swap($a,$b);
				swap($minp,$maxp);
			} 
			$b.="0";
			$a.="0";
			$c="0";
			for($i=0,$i<=$minp;$i++)
			{
				$d=strrev(simplePlus(simplePlus($a[$i],$b[$i]),$c));
				$b[$i]=$d[0];
				$c=pos($d,1);
			}
			if($b[$maxp]=='0') $b=substr($b,0,$maxp); else $maxp+=1;
			$this->val=$b;
			$this->length=$maxp;
			return $this;
		}
		else
		{
			return selfMinus(new StringInteger($r->val,!$r->isNegative,false));
		}		
	}
	
	public function selfMinus($r)
	{
		if($this->isNegative==$r->isNegative)
		{
			$a=$this->val."0";
			$b=$r->val."0";
			$minp=$this->length;
			$maxp=$r->length;
			$c1=$this->isNegative;
			$c2=$r->isNegative;
			arrange($a,$b,$minp,$maxp,$c1,$c2);
			$c="0";
			$mi=-1;
			for($i=0;$i<=$minp;$i++)
			{
				$d=simpleMinus($b[$i],simplePlus($a[$i],$c));
				$c=$d[1];
				$b[$i]=$d[0];
				if($d[0]!='0') $mi=$i;
			}
			if($mi==-1)
			{
				$b="0";
				$maxp=1;
				$c2=false;
			}			
			else
			{
				$b=substr($b,0,$mi+1);
				$maxp=$mi+1;
			}
			$this->val=$b;
			$this->length=$maxp;
			$this->isNegative=$c2;
			return $this;
		}
		else
		{
			return selfPlus(new StringInteger($r->val,!$r->isNegative,false,$r->length));
		}		
	}
	
	public function selfMultiply($r)
	{
		$a=$this->val;
		$b=$r->val;
		$minp=$this->length;
		$maxp=$r->length;
		if($minp>$maxp)
		{
			swap($a,$b);
			swap($minp,$maxp);
		} 
		$b.="0";
		$sum=new StringInteger("0",false,false);
		for($i=0;$i<$minp;$i++)
		{
			$br=simpleMultiply2($a[$i],$b);
			$sum=$sum->plus(new StringInteger(str_repeat("0",$i).$br[0],false,false,$br[1]+$i));
		}
		if($this->isNegative!=$r->isNegative)
			$sum->isNegative=true;
		$this->val=$sum->val;
		$this->length=$sum->length;
		$this->isNegative=$sum->isNegative;
		return $this;		
	}
	
	public function selfDivide($r)
	{
		$a=$this->val;
		$b=$r->val;
		$alength=$this->length;
		$blength=$r->length;
		$c1=$this->isNegative;
		$c2=$r->isNegative;
		
		$q="";
		$ret="";
		$retlength=0;
		for($i=$alength-1;$i>-1;$i--)
		{
			$q=$a[$i].$q;
			$c=simplyDivide($q,$b,$c[1]->length,$blength);
			if($ret!="" or $c[0]!="0") 
			{
				$ret.=$c[0];
				$retlength+=1;
			}
			$q=$c[1]->val;
		}
		if($retlength==0 or $ret=="")
		{
			$retlength=1;
			$ret="0";
		}
		if($c1==$c2) $retSign=false; else $retSign=true;
		$this->val=strrev($ret);
		$this->lengt=$retlength;
		$this->isNegative=$retSign;
		return $this;
	}
	
	public function selfRemainder($r)
	{
		$a=$this->val;
		$b=$r->val;
		$alength=$this->length;
		$blength=$r->length;
		$c1=$this->isNegative;
		$c2=$r->isNegative;
		
		$q="";
		$ret="";
		$retlength=0;
		for($i=$alength-1;$i>-1;$i--)
		{
			$q=$a[$i].$q;
			$c=simplyDivide($q,$b,$c[1]->length,$blength);
			if($ret!="" or $c[0]!="0") 
			{
				$ret.=$c[0];
				$retlength+=1;
			}
			$q=$c[1]->val;
		}
		if($retlength==0 or $ret=="")
		{
			$retlength=1;
			$ret="0";
		}
		if($c1==$c2) $retSign=false; else $retSign=true;
		$this->val=$c[1]->val;
		$this->length=$c[1]->length;
		$this->isNegative=$retSign;
		return $this;		
	}
	
	public function isEqual($r)
	{
		if($r->val==$this->val and ($r->isNegative==$this->isNegative or $r->val=="0")) return true;
		return false;
	}
	
	public function isSmallerThanZero()
	{
		if($this->isNegative()==true and $this->isEqual(new StringInteger("0"))==false)
			return true;
		return false;
	}
	
//PRIVATE
		
	private function pos($s,$p) //$s is string, $p is integer
	{
		if($p>=strlen($s)) return "0";
		return $s[$p];
	}	

	//Assumption: $a and $b are both positive numbers with digits in reverse order.
	private function smaller($a,$b)
	{
		return smaller($a,$b,strlen($a),strlen($b));
	}
	
	//Assumption: $a and $b are both positive numbers with digits in reverse order.
	private function smaller($a,$b,$alength,$blength)	 
	{
		if($alength>$blength) return 1;
		if($alength<$blength) return -1;
		for($i=$alength-1;$i>-1;$i--)
		{
			if($a[$i]>$b[i])
				return 1;
			elseif($a[i]<$b[$i])
				return -1;
		}
		return 0;
	}
		
	//Assumption: $a and $b are both positive numbers with digits in reverse order.
	private function arrange(&$a,&$b,&$alength,&$blength,&c1,&c2)
	{
		$i=smaller($a,$b,$alength,$blength);
		if($i>0)
		{
			swap($a,$b);
			swap($alength,$blength);
			swap($c1,$c2);
		}
		return $i;
	}
	
	private function simplePlus($a,$b) //$a is string, $b is string
	{
		return (string)($a+$b);
	}

	private function simpleMinus($a,$b) //$a is string
	{
		$r=$a-$b;
		if($r>=0) return Array((string)$r,"0");
		return Array((string)($r+10),"1");
	}
	
	private function simpleMultiply($a,$b) //$a is string, $b is string
	{
		return (string)($a*$b);
	}

	//Assumptions: $b is reverse, and followed by 0, and $blength is $b's length excluding the trailing 0.
	private function simpleMultiply2($a,$b,$blength) //$a is string of single digit, $b is string
	{
		$c="0";
		for($i=0;$i<=$blength;$i++)
		{
			$d=strrev(simplePlus(simpleMultiply($a,$b[$i]),$c));
			$b[$i]=$d[0];
			$c=pos($d,1);
		}
		if($b[$blength]=='0') $b=substr($b,0,$blength); else $blength+=1;
		return Array($b,$blength);	
	}
	
	//will return the single digit between 0 and 9.
	private function simplyDivide($a,$b,$alength,$blength) //$a is string/big num, $b is string/small num
	{
		$c=new StringInteger("0".$b,false,false,$blength+1);
		for($i=9;$i>-1;$i--)
		{
			$c=$c->minus(new StringInteger($b,false,false,$blength)); 
			if(smaller($a,$c,$alength,$c->length)>=0)
				break;
		}
		return Array($i,$a->minus($c)); //returns Array(quotient,remainder)
	}
	
	private function divideHelper($r) //$r is StringInteger
	{
		$a=$this->val;
		$b=$r->val;
		$alength=$this->length;
		$blength=$r->length;
		$c1=$this->isNegative;
		$c2=$r->isNegative;
		
		$q="";
		$ret="";
		$retlength=0;
		for($i=$alength-1;$i>-1;$i--)
		{
			$q=$a[$i].$q;
			$c=simplyDivide($q,$b,$c[1]->length,$blength);
			if($ret!="" or $c[0]!="0") 
			{
				$ret.=$c[0];
				$retlength+=1;
			}
			$q=$c[1]->val;
		}
		if($retlength==0 or $ret=="")
		{
			$retlength=1;
			$ret="0";
		}
		if($c1==$c2) $retSign=false; else $retSign=true;
		$c[1]->isNegative=$retSign;
		return Array(new StringInteger(strrev($ret),$retSign,false,$retlength),$c[1]);
	}
}

class RealNumber
{
	private $n=0;
	private $d=1;
	
	//Assumption: sign is always carried by the numerator.
	public function __construct($n=0,$d=1,$dontReduce=false)
	{
		$this->n=intval($n);
		$this->d=intval($d);
		if(!$dontReduce) selfReduce();
	}	
	
	private function reduce()
	{
		$a=$this->n;
		$b=$this->d;
		$hcf=hcf($a,$b);
		$a/=$hcf;
		$b/=$hcf;
		return new RealNumber($a,$b,true);
	}
	
	private function selfReduce()
	{
		$hcf=hcf($this->n,$this->d);
		$this->n/=$hcf;
		$this->d/=$hcf;
		return $this;
	}
	
	public function plus($r)	//$r is RealNumber
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->n;
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=$d2/$hcf;
		$n=$n1*$f+$n2*($d1/$hcf);
		$d=$f*$d1;
		reduce2($n,$d);
		return new RealNumber($n,$d,true);
	}
	
	public function minus($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=-$r->n;
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=$d2/$hcf;
		$n=$n1*$f+$n2*($d1/$hcf);
		$d=$f*$d1;
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
		return new RealNumber($n1*$n2,$d1*$d2,true);
	}

	public function divide($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->d;
		$d2=$r->n;
		if($d2<0) 
		{
			$d2*=-1;
			$n2*=-1;
		}
		reduce2($n1,$d2);
		reduce2($n2,$d1);
		return new RealNumber($n1*$n2,$d1*$d2,true);
	}
	
	public function inverse()
	{
		if($this->n<0) return new RealNumber(-$this->d,-$this->n,true);
		return new RealNumber($this->d,$this->n,true);
	}
	
	public function selfPlus($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->n;
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=$d2/$hcf;
		$this->n=$n1*$f+$n2*($d1/$hcf);
		$this->d=$f*$d1;
		selfReduce();
		return $this;		
	}
	
	public function selfMinus($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=-$r->n;
		$d2=$r->d;
		$hcf=hcf($d1,$d2);
		$f=$d2/$hcf;
		$this->n=$n1*$f+$n2*($d1/$hcf);
		$this->d=$f*$d1;
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
		$this->n=$n1*$n2;
		$this->d=$d1*d2;
		return $this;
	}
	
	public function selfDivide($r)
	{
		$n1=$this->n;
		$d1=$this->d;
		$n2=$r->d;
		$d2=$r->n;
		if($d2<0) 
		{
			$d2*=-1;
			$n2*=-1;
		}
		reduce2($n1,$d2);
		reduce2($n2,$d1);
		$this->n=$n1*$n2;
		$this->d=$d1*d2;
		return $this;
	}
	
	public function selfInverse()
	{
		if($this->n<0)
		{
			$this->n*=-1;
			$this->d*=-1;
		} 
		swap($this->n,$this->d);
		return $this;
	}
}

class StringRealNumber
{
	private $n=new StringInteger("0");
	private $d=new StringInteger("1");
	
	//Assumption: sign is always carried by the numerator.
	public function __construct($n=null,$d=null,$dontReduce=false,$isStringRealNumber=false) //$n and $d are string/integer
	{
		if($isStringRealNumber)
		{
			if($n!=null) $this->n=$n->copy();
			if($d!=null) $this->d=$d->copy();
		}
		else
		{
			if($n!=null) $this->n=new StringInteger($n);
			if($d!=null) $this->d=new StringInteger($d);
		}
		if(!$dontReduce) selfReduce();			
	}	
		
	private function reduce()
	{
		$a=$this->n->copy();
		$b=$this->d->copy();
		$hcf=hcfString($a,$b);
		$a->selfDivide($hcf);
		$b->selfDivide($hcf);
		return new StringRealNumber($a,$b,true,true);
	}
	
	private function selfReduce()
	{
		$hcf=hcfString($this->n,$this->d);
		$this->n->selfDivide($hcf);
		$this->d->selfDivide($hcf);
		return $this;
	}

	public function plus($r)	//$r is RealNumber
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->n->copy();
		$d2=$r->d->copy();
		$hcf=hcfString($d1,$d2);
		$f=$d2->divide($hcf);
		$n=$n1->multiply($f)->plus($n2->multiply($d1->divide($hcf)));
		$d=$f->divide($d1);
		reduce2String($n,$d);
		return new StringRealNumber($n,$d,true,true);
	}
	
	public function minus($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->n->copy();
		$n2->switchNegative();
		$d2=$r->d->copy();
		$hcf=hcfString($d1,$d2);
		$f=$d2->divide($hcf);
		$n=$n1->multiply($f)->plus($n2->multiply($d1->divide($hcf)));
		$d=$f->multiply($d1);
		reduce2String($n,$d);
		return new StringRealNumber($n,$d,true,true);
	}
	
	//Assumption: $r and $this are already reduced.
	public function multiply($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->n->copy();
		$d2=$r->d->copy();
		reduce2String($n1,$d2);
		reduce2String($n2,$d1);
		return new StringRealNumber($n1->multiply($n2),$d1->multiply($d2),true,true);
	}

	public function divide($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->d->copy();
		$d2=$r->n->copy();
		if($d2->isSmallerThanZero())
		{
			$d2->switchNegative();
			$n2->switchNegative();
		}
		reduce2String($n1,$d2);
		reduce2String($n2,$d1);
		return new StringRealNumber($n1->multiply($n2),$d1->multiply($d2),true,true);
	}
	
	public function inverse()
	{
		if($this->n->isSmallerThanZero())
		{
			$a=$this->d->copy();
			$b=$this->n->copy();
			$a->switchNegative();
			$b->switchNegative();
			return new StringRealNumber($a,$b);
		}			
		return new StringRealNumber($this->d,$this->n,true,true);
	}
	
	public function selfPlus($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->n->copy();
		$d2=$r->d->copy();
		$hcf=hcfString($d1,$d2);
		$f=$d2->divide($hcf);
		$this->n=$n1->multiply($f)->plus($n2->multiply($d1->divide($hcf)));
		$this->d=$f->divide($d1);
		selfReduce();
		return $this;		
	}
	
	public function selfMinus($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->n->copy();
		$n2->switchNegative();
		$d2=$r->d->copy();
		$hcf=hcfString($d1,$d2);
		$f=$d2->divide($hcf);
		$this->n=$n1->multiply($f)->plus($n2->multiply($d1->divide($hcf)));
		$this->d=$f->multiply($d1);
		selfReduce();
		return $this;		
	}
	
	public function selfMultiply($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->n->copy();
		$d2=$r->d->copy();
		reduce2String($n1,$d2);
		reduce2String($n2,$d1);
		$this->n=$n1->multiply($n2);
		$this->d=$d1->multiply($d2);
		return $this;
	}
	
	public function selfDivide($r)
	{
		$n1=$this->n->copy();
		$d1=$this->d->copy();
		$n2=$r->d->copy();
		$d2=$r->n->copy();
		if($d2->isSmallerThanZero())
		{
			$d2->switchNegative();
			$n2->switchNegative();
		}
		reduce2String($n1,$d2);
		reduce2String($n2,$d1);
		$this->n=$n1->multiply($n2);
		$this->d=$d1->multiply($d2);
		return $this;
	}
	
	public function selfInverse()
	{
		if($this->n->isSmallerThanZero())
		{
			$this->n->switchNegative();
			$this->d->switchNegative();
		} 
		swap($this->n,$this->d);
		return $this;
	}

}







function hcf($a,$b)
{
	if($a%$b==0) return $b;
	return hcf($b,$a%$b);
}

function lcm($a,$b)
{
	$hcf=hcf($a,$b);
	reduce2($a,$hcf); 
	return $a*$b;
}

function reduce1($a,$b)
{
	$hcf=hcf($a,$b);
	return Array($a/$hcf,$b/$hcf);
}

function reduce2(&$a,&$b)
{
	$hcf=hcf($a,$b);
	$a/=$hcf;
	$b/=$hcf;	
}

function hcfString($a,$b) //$a, $b are both StringInteger
{
	if($a->remainder($b)->isEqual(new StringInteger("0"))) return $b;
	return hcfString($b,$a->remainder($b));
}

function lcmString($a,$b)
{
	$hcf=hcfString($a,$b);
	reduce2String($a,$hcf); 
	return $a->multiply($b);
}

function reduce1String($a,$b)
{
	$hcf=hcfString($a,$b);
	return Array($a->divide($hcf),$b->divide($hcf));
}

function reduce2String(&$a,&$b)
{
	$hcf=hcfString($a,$b);
	$a->selfDivide($hcf);
	$b->selfDivide($hcf);	
}	

?>