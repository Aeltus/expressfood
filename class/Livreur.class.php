<?php
/**
 *
 * @see        Employe
 */

class Livreur extends Employe {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idLivreur;

	/**
	 * 
	 * @var float
	 * @access private
	 */
	private  $locationLat;

	/**
	 * 
	 * @var float
	 * @access private
	 */
	private  $locationLong;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $villeRatach;


    /**
     *
     * @var bool
     * @access private
     */
    private  $dispo;


	/**
	 * @access public
	 * @return float
	 */

	public  function getLocationLat() {
        return $this->locationLat;
	}


	/**
	 * @access public
	 * @return float
	 */

	public function getLocationLong() {
        return $this->locationLong;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getVilleRatach() {
        return $this->villeRatach;
	}


	/**
	 * @access public
	 * @param float $locationLat 
	 * @return void
	 */

	public  function setLocationLat($locationLat) {
        $this->locationLat = $locationLat;
	}


	/**
	 * @access public
	 * @param float $LocationLong 
	 * @return void
	 */

	public final  function setLocationLong($LocationLong) {
        $this->locationLong = $LocationLong;
	}


	/**
 * @access public
 * @param string $villeRatach
 * @return void
 */

    public final  function setVilleRatach($villeRatach) {
        $this->villeRatach = $villeRatach;
    }



    /**
     * @access public
     * @param bool $valeur
     * @return void
     */

    public final  function setDispo($valeur) {
        $this->dispo = $valeur;
    }

    /**
     * @access public
     * @return bool
     */

    public final  function getdispo() {
        return $this->dispo;
    }

}
?>