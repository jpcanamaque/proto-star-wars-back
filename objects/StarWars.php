<?php
/**
 * @file StarWars.php
 * @brief Contains the class and methods for the StarWars test for Prototype
 * @author Johnroe Paulo Canamaque <jpcanamaque@gmail.com>
 * @date February 2020
 */

/**
 * @brief Main class for the StarWars tests
 */
class StarWars {
    private $conn;

    /**
     * @brief Constructor method for the StarWars class
     * @params object $db
     *  - Database object handle
     * @return StarWars $this
     */
    public function __construct ($db) {
        $this->conn = $db;
        return $this;
    }

    /**
     * @brief Gets the title of the Star Wars movie with the longest opening crawl
     * @return array $data 
     *  - Contains the title/s and the length of the opening crawl
     */
    public function getLongestOpenCrawl () {
        $query = "SELECT title, LENGTH(opening_crawl) opening_crawl_length FROM films
            ORDER BY LENGTH(opening_crawl) DESC
            ";
        
        $res = $this->conn->query($query);
        $data = array();
        $max = 0;
        while($r = $res->fetch_assoc()) {
            if($max == 0) $max = $r['opening_crawl_length'];

            if($max <= $r['opening_crawl_length']) {
                $data[] = $r;
            }
        }
        $res->close();
        return $data;
    }

    /**
     * @brief Gets the character with the most appearance in all StarWars franchise
     * @return array $data 
     *  - Contains an array of the id, name, and the number of appearance in all StarWars franchise
     */
    public function getMostCharacterAppearance () {
        $query = "SELECT p.id, p.name, COUNT(p.id) num_appearance FROM films f
        LEFT JOIN films_characters fc ON f.id = fc.film_id
        LEFT JOIN people p ON fc.people_id = p.id
        GROUP BY p.id
        ORDER BY COUNT(p.id) DESC";
        $res = $this->conn->query($query);
        $data = array();
        $max = 0;
        while($r = $res->fetch_assoc()) {
            if($max == 0) $max = $r['num_appearance'];

            if($max <= $r['num_appearance']) {
                $data[] = $r;
            }
        }
        $res->close();
        return $data;
    }

    /**
     * @brief Gets the species with the most appearance in the StarWars franchise
     * @return array $data 
     *  - Contains an array of the id, species, and the number of appearance in all StarWars franchise
     */
    public function getMostSpeciesAppearance () {
        $query = "SELECT s.id, s.name, COUNT(s.id) num_appearance FROM films f
            LEFT JOIN films_species fs ON f.id = fs.film_id
            LEFT JOIN species s ON fs.species_id = s.id
            LEFT JOIN species_people sp ON s.id = sp.species_id
            LEFT JOIN people p ON sp.people_id = p.id
            GROUP BY s.id
            ORDER BY COUNT(s.id) DESC";
        $res = $this->conn->query($query);
        $data = array();
        $max = 0;
        while($r = $res->fetch_assoc()) {
            if($max == 0) $max = $r['num_appearance'];

            if($max <= $r['num_appearance']) {
                $data[] = $r;
            }
        }
        $res->close();
        return $data;
    }

    /**
     * @name getMostVehiclePilot
     * @brief Gets the planet with the most vehicle driver/s, with their corresponding name and species 
     * @return array $data
     */
    public function getMostVehiclePilot () {
        $query = "SELECT 
            DISTINCT pl.NAME planet_name
            , p.NAME char_name
            , IF(s.name IS NULL, 'UNKNOWN', s.NAME) species_name
        FROM 
            people p 
         JOIN vehicles_pilots vp ON p.id = vp.people_id
         JOIN vehicles v ON vp.vehicle_id = v.id
         JOIN planets pl ON pl.id = p.homeworld
         LEFT JOIN species_people sp ON sp.people_id = p.id
         LEFT JOIN species s ON s.id = sp.species_id;
        ";
        $res = $this->conn->query($query);
        $data = array();
        while($r = $res->fetch_object()) {
            if(!isset($data[$r->planet_name])) {
                $data[$r->planet_name] = array();
            }

            $data[$r->planet_name][] = array(
                'driver' => $r->char_name
                , 'species' => $r->species_name
            );
        }

        // Getting the planet/s with the highest number of drivers
        $GLOBALS['highest_planet'] = array();
        $max = 0;
        foreach($data as $k => $v) {
            if($max == 0) $max = count($v);
            if($max <= count($v)) {
                $GLOBALS['highest_planet'][] = $k;
            }
        }

        $res->close();
        return array(
            array_filter($data, function($d, $k) {
                return in_array($k, $GLOBALS['highest_planet']);
            }, ARRAY_FILTER_USE_BOTH)
        );
    }
}