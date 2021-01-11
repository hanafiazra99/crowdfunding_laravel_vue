<?php
trait Hewan{
    public $nama,$darah=50,$jumlahKaki,$keahlian;

    public function __construct($nama,$jumlahKaki,$keahlian){
        $this->nama = $nama;
        $this->jumlahKaki = $jumlahKaki;
        $this->keahlian = $keahlian;
    }

    public function atraksi(){
        echo $this->nama.' sedang '.$this->keahlian ;
    }

}

trait Fight{
    public $attackPower,$defensePower;

    public function __construct($attackPower,$defensePower){
        $this->attackPower = $attackPower;
        $this->defensePower = $defensePower;
    }
    public function serang(Hewan $hewan){
        echo $this->nama.' menyerang '.$hewan->nama;
    }
    public function diserang(Hewan $hewan){
        echo $this->nama.' sedang diserang, Sisa darah : '.$this->darah-($hewan->attackPower/$hewan->defensePower);
    }
}

class Elang{
    use Hewan{
        Hewan::__construct as private __hConstruct;
    }
    use Fight{
        Fight::__construct as private __fConstruct;
    }
    public function __construct()
    {
        $this->__hConstruct('Elang',2,'Terbang Tinggi');
        $this->__fConstruct(10,5);
    }
    public function getInfoHewan(){
        echo $this->nama;
        echo $this->jumlahKaki;
        echo $this->keahlian;
        echo $this->darah;
        echo $this->attackPower;
        echo $this->defensePower;
    }
}
class Harimau{
    use Hewan{
        Hewan::__construct as private __hConstruct;
    }
    use Fight{
        Fight::__construct as private __fConstruct;
    }
    public function __construct()
    {
        $this->__hConstruct('Harimau',4,'Lari Kencang');
        $this->__fConstruct(10,5);
    }
    public function getInfoHewan(){
        echo $this->nama;
        echo $this->jumlahKaki;
        echo $this->keahlian;
        echo $this->darah;
        echo $this->attackPower;
        echo $this->defensePower;
    }
}

$hewan1 = new Elang();
$hewan2 = new Harimau();
$hewan1->serang($hewan2);
$hewan1->diserang($hewan2);
$hewan2->serang($hewan1);
$hewan2->diserang($hewan1);
?>