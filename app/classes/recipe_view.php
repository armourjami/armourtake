<?php
class recipe_view {
	private $_name;
	private $_yeild;
	private $_yeild_unit;
	private $_method;
	private $_cost;
	private $_user_id;

	public function __construct($idRecipe, $user_id){
		$this->_db = STOCK_DB::getInstance();						
		$this->_user_id = $user_id;
		
		$recipe = $this->_db->get('Recipes', ['idRecipe', '=', $idRecipe], $this->_user_id);
		$recipe = $recipe->first();
			
		
	}

}

?>
