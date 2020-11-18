<?php
declare(strict_types=1);
require_once "Revir.php";
class database
{
    private $user = "root";
    private $pass = "dtb456";
    private $db = "semestralka";
    private $host = "localhost";
    private PDO $pdo;
    
    public function __construct()
    {
        $this->pdo= new PDO("mysql:dbname={$this->db};host={$this->host}", $this->user,$this->pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);
    }
   
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM reviry");
        $reviry=[];
        while ($row = $stmt->fetch()) {
            $revir = new Revir((int)$row['cislo_reviru'],$row['popis']);
            $reviry[] = $revir;
        }
        return $reviry;
    }
    public function saveRevir(Revir $revir) : void
    {
            $stmt = $this->pdo->prepare("INSERT INTO reviry(cislo_reviru, popis) VALUES(?, ?)");
            $stmt->execute([$revir->getCisloReviru(), $revir->getPopis()]);
    }
    public function createRevir(int $revir,string $text):bool
    {
        try {
            $revir = new Revir($revir, $text);
            $this->saveRevir($revir);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function editRevir(int $id, Revir $revir): bool
    {
        try {
            if($id==$revir->getCisloReviru()) {
                $stmt = $this->pdo->prepare("UPDATE reviry SET popis=? WHERE id=(?)");
                $stmt->execute([$revir->getPopis(), $id]);
            }else{
                $stmt = $this->pdo->prepare("UPDATE reviry SET cislo_reviru=?, popis=? WHERE id=(?)");
                $stmt->execute([$revir->getCisloReviru(), $revir->getPopis(), $id]);
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getZmenaReviru(int $id) : array{
        $stmt = $this->pdo->prepare("SELECT * FROM reviry WHERE id = (?)");
        $stmt->execute([$id]);
        $revir=[];
        while ($row = $stmt->fetch()) {
            $revir['cisloReviru'] = $row['cislo_reviru'];
            $revir['popis'] = $row['popis'];
        }
        return revir;
    }
    public function kontrola(int $cisloReviru) : bool {
        $stmt = $this->pdo->prepare("SELECT * FROM reviry WHERE cislo_reviru = (?)");
        $stmt->execute([$cisloReviru]);
        return $stmt->rowCount()==0 ;
    }
    public function getIdReviru(int $cisloReviru) : string {
        $stmt = $this->pdo->prepare("SELECT * FROM reviry WHERE cislo_reviru = (?)");
        $stmt->execute([$cisloReviru]);
        return $stmt->fetch()["id"];
    }
    public function mazanie(int $cisloReviru) {
        $stmt = $this->pdo->prepare("DELETE FROM reviry WHERE cislo_reviru = (?)");
        $stmt->execute([$cisloReviru]);
    }
}