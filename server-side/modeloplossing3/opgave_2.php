<?php

/**
 * Lab 03, Exercise 2 — Solution
 * @author Joris Maervoet <joris.maervoet@odisee.be>
 */

class Person {

	static $familySize = 0;

	private $name;
	private $mother;
	private $father;
	private $children = array();

	/**
	 * Person constructor.
	 * @param string $name
	 * @param Person $mother
	 * @param Person $father
	 */
	public function __construct($name, $mother = null, $father = null)
	{
		$this->name = $name;
		$this->mother = $mother;
		$this->father = $father;

		// Register this person as a child of the mother and father
		if ($this->mother !== null) {
			$this->mother->children[] = $this;
		}
		if ($this->father !== null) {
			$this->father->children[] = $this;
		}

		self::$familySize++;
	}

	public function __destruct() {
		self::$familySize--;
	}

	public function getParents() {
		$parents = array();
		if ($this->mother !== null) {
			$parents[] = $this->mother;
		}
		if ($this->father !== null) {
			$parents[] = $this->father;
		}
		return $parents;
	}

	public function getAncestors() {
		$ancestors = array();
		$parents = $this->getParents();
		foreach ($parents as $parent) {
			$ancestors[] = $parent;
			$ancestors = array_merge($ancestors, $parent->getAncestors());
		}
		return $ancestors;
	}

	public function printAncestors($stars = 1) {
		$parents = $this->getParents();
		foreach ($parents as $parent) {
			$parent->printAncestors($stars+1);
			echo str_repeat('*', $stars) . $parent . '<br/>';
		}
	}

	public function getGrandchildren() {
		$grandchildren = array();
		foreach ($this->children as $child) {
			$grandchildren = array_merge($grandchildren, $child->children);
		}
		return $grandchildren;
	}

	public function getSiblings() {
		$siblings = array();
		$parents = $this->getParents();
		foreach ($parents as $parent) {
			foreach ($parent->children as $sibling) {
				if (($sibling !== $this) && (! in_array($sibling, $siblings ))) {
					$siblings[] = $sibling;
				}
			}
		}
		return $siblings;
	}

	public function __toString() {
		return $this->name;
	}

}
$hub = new Person('Hubert');	$gis = new Person('Gislaine');
$mar = new Person('Marinus');	$gab = new Person('Gabrielle');
$gas = new Person('Gaston', $gis, $hub);	$jo = new Person('Jo', $gab, $mar);
$gon = new Person('Gonda', $gis, $hub);		$eri = new Person('Erik');
$bar = new Person('Bart', $gon, $eri);		$kat = new Person('Katrijn', $gon, $eri);

$rik = new Person('Rik', $gab, $mar);
$jor = new Person('Joris', $jo, $gas);		$lor = new Person('Lore');
$fer = new Person('Ferre', $lor, $jor);		$dau = new Person('Dauwke', $lor, $jor);

echo $hub . '<br/>';
echo implode(' + ', $gab->getParents()) . '<br/>';
echo implode(' + ', $gas->getGrandchildren()) . '<br/>';
echo implode(' + ', $hub->getGrandchildren()) . '<br/>';
echo implode(' + ', $jor->getAncestors()) . '<br/>';
echo implode(' + ', $fer->getSiblings()) . '<br/>';
$fer->printAncestors();
echo Person::$familySize;


// EOF