<?php

class Game
{
    private $id;
    private $title;
    private $release_date;
    private $link;
    private $developer_id;
    private $platform_id;

    public function __construct(int $id = null, string $title = "", string $release_date, string $link = "", int $developer_id = 0, int $platform_id = 0)
    {
        $this->id = $id;
        $this->title = $title;
        $this->release_date = $release_date;
        $this->link = $link;
        $this->developer_id = $developer_id;
        $this->platform_id = $platform_id;
    }

    public function create()
    {
        global $connexionDataBaseVideoGames;
        $stmt = $connexionDataBaseVideoGames->prepare("
            INSERT INTO `game` (
                `title`, 
                `release_date`, 
                `link`, 
                `developer_id`, 
                `platform_id`
            ) 
            VALUES (
                :title, 
                :release_date, 
                :link, 
                :developer_id, 
                :platform_id
            )
        ");
        $stmt->execute([
            ':title' => $this->title,
            ':release_date' => $this->release_date,
            ':link' => $this->link,
            ':developer_id' => $this->developer_id,
            ':platform_id' => $this->platform_id
        ]);

        $this->id = $connexionDataBaseVideoGames->lastInsertId();
    }

    public function delete()
    {
        global $connexionDataBaseVideoGames;
        $connexionDataBaseVideoGames->exec('DELETE FROM `game` WHERE `id` = ' . $this->id);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of release_date
     */
    public function getRelease_date()
    {
        return $this->release_date;
    }

    /**
     * Set the value of release_date
     *
     * @return  self
     */
    public function setRelease_date($release_date)
    {
        $this->release_date = $release_date;

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

    /**
     * Get the value of developer_id
     */
    public function getDeveloper_id()
    {
        return $this->developer_id;
    }

    /**
     * Set the value of developer_id
     *
     * @return  self
     */
    public function setDeveloper_id($developer_id)
    {
        $this->developer_id = $developer_id;

        return $this;
    }

    /**
     * Get the value of platform_id
     */
    public function getPlatform_id()
    {
        return $this->platform_id;
    }

    /**
     * Set the value of platform_id
     *
     * @return  self
     */
    public function setPlatform_id($platform_id)
    {
        $this->platform_id = $platform_id;

        return $this;
    }

    public function getDeveloper()
    {
        return fetchDeveloperById($this->developer_id);
    }

    public function getPlatform()
    {
        return fetchPlatformById($this->platform_id);
    }

    public function dateFormatChange()
    {
        $date = DateTime::createFromFormat('Y-m-d', $this->release_date);
        return $date->format('d M Y');
    }
}

function createGame($id, $title, $release_date, $link, $developer_id, $platform_id): Game
{
    return new Game($id, $title, $release_date, $link, $developer_id, $platform_id);
}

function fetchAllGamesOrderBy(string $column = 'id', string $order = 'asc')
{
    global $connexionDataBaseVideoGames;
    $stmt = $connexionDataBaseVideoGames->query("SELECT * FROM `game` ORDER BY " . $column . " " . $order);
    return $stmt->fetchAll(PDO::FETCH_FUNC, "createGame");
}

function fetchGameById(int $id)
{
    global $connexionDataBaseVideoGames;
    $stmt = $connexionDataBaseVideoGames->prepare("SELECT * FROM `game` WHERE `id` = :id");
    $stmt->execute([
        ':id' => $id
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_FUNC, "createGame");
    return $result[0];
}