<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class StarWarsTest extends TestCase {
    public function testGetMovieWithLongestCrawl()  {
        $result = file_get_contents('http://localhost/swapi/api/longest_crawl.php');
        $this->assertEquals(
            '[{"title":"A New Hope","opening_crawl_length":"522"}]'
            , $result
        );
    }

    public function testGetCharacterWithMostAppearance()  {
        $result = file_get_contents('http://localhost/swapi/api/most_char_appearance.php');
        $this->assertEquals(
            '[{"id":"2","name":"C-3PO","num_appearance":"6"},{"id":"3","name":"R2-D2","num_appearance":"6"},{"id":"10","name":"Obi-Wan Kenobi","num_appearance":"6"}]'
            , $result
        );
    }

    public function testGetSpeciesWithMostAppearance()  {
        $result = file_get_contents('http://localhost/swapi/api/most_spec_appearance.php');
        $this->assertEquals(
            '[{"id":"1","name":"Human","num_appearance":"24"},{"id":"2","name":"Droid","num_appearance":"24"}]'
            , $result
        );
    }

    public function testGetPlanetWithMostVehiclePilot()  {
        $result = file_get_contents('http://localhost/swapi/api/most_vehicle_pilot.php');
        $this->assertEquals(
            '[{"Tatooine":[{"driver":"Luke Skywalker","species":"UNKNOWN"},{"driver":"Anakin Skywalker","species":"UNKNOWN"}]}]'
            , $result
        );
    }
}