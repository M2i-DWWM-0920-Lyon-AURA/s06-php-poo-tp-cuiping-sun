<?php

class Platform
{
    private $id;
    private $name;
    private $link;

    public function __construct(int $id = null, string $name = "", string $link = "")
    {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of link
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */ 
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

}

function createPlatform($id, $name, $link): Platform
{
    return new Platform($id, $name, $link);
}

function fetchAllPlatform()
{
    global $connexionDataBaseVideoGames;
    $stmt = $connexionDataBaseVideoGames->query("SELECT * FROM `platform`");
    return $stmt->fetchAll(PDO::FETCH_FUNC, "createPlatform");
}

function fetchPlatformById($id)
{
    global $connexionDataBaseVideoGames;
    $stmt = $connexionDataBaseVideoGames->prepare("SELECT * FROM `platform` WHERE `id`=:id");
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetchAll(PDO::FETCH_FUNC, "createPlatform");
    if (empty($result)) {
        return null;
    }
    return $result[0];
}