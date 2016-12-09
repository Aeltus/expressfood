<?php
/**
 *
 * @see        Utilisateur
 */

class Client extends Utilisateur {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idClient;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $numero;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $rue;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $codePostal;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $ville;

	/**
	 * @access public
	 * @return int
	 */

	public  function getNumero() {
        return $this->numero;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getRue() {
        return $this->rue;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getCodePostal() {
        return $this->codePostal;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getVille() {
        return $this->ville;
	}


	/**
	 * @access public
	 * @param int $numero 
	 * @return void
	 */

	public  function setNumero($numero) {
        $this->numero = $numero;
	}


	/**
	 * @access public
	 * @param string $rue 
	 * @return void
	 */

	public  function setRue($rue) {
        $this->rue = $rue;
	}


	/**
	 * @access public
	 * @param int $codePostal 
	 * @return void
	 */

	public  function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
	}


	/**
	 * @access public
	 * @param string $ville 
	 * @return void
	 */

	public  function setVille($ville) {
        $this->ville = $ville;
	}


}
?>