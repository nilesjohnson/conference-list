<?php
/**
 * TagFixture
 *
 */
class TagFixture extends CakeTestFixture {
        public $useDbConfig = 'test';
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
				array('id'=>1, 'name'=>'ac.commutative-algebra'),
				array('id'=>2, 'name'=>'ag.algebraic-geometry'),
				array('id'=>3, 'name'=>'ap.analysis-of-pdes'),
				array('id'=>4, 'name'=>'at.algebraic-topology'),
				array('id'=>5, 'name'=>'ca.classical-analysis-and-odes'),
				array('id'=>6, 'name'=>'co.combinatorics'),
				array('id'=>7, 'name'=>'ct.category-theory'),
				array('id'=>8, 'name'=>'cv.complex-variables'),
				array('id'=>9, 'name'=>'dg.differential-geometry'),
				array('id'=>10, 'name'=>'ds.dynamical-systems'),
				array('id'=>11, 'name'=>'fa.functional-analysis'),
				array('id'=>12, 'name'=>'gm.general-mathematics'),
				array('id'=>13, 'name'=>'gn.general-topology'),
				array('id'=>14, 'name'=>'gr.group-theory'),
				array('id'=>15, 'name'=>'gt.geometric-topology'),
				array('id'=>16, 'name'=>'ho.history-and-overview'),
				array('id'=>17, 'name'=>'it.information-theory'),
				array('id'=>18, 'name'=>'kt.k-theory-and-homology'),
				array('id'=>19, 'name'=>'lo.logic'),
				array('id'=>20, 'name'=>'mg.metric-geometry'),
				array('id'=>21, 'name'=>'mp.mathematical-physics'),
				array('id'=>22, 'name'=>'na.numerical-analysis'),
				array('id'=>23, 'name'=>'nt.number-theory'),
				array('id'=>24, 'name'=>'oa.operator-algebras'),
				array('id'=>25, 'name'=>'oc.optimization-and-control'),
				array('id'=>26, 'name'=>'pr.probability'),
				array('id'=>27, 'name'=>'qa.quantum-algebra'),
				array('id'=>28, 'name'=>'ra.rings-and-algebras'),
				array('id'=>29, 'name'=>'rt.representation-theory'),
				array('id'=>30, 'name'=>'sg.symplectic-geometry'),
				array('id'=>31, 'name'=>'sp.spectral-theory'),
				array('id'=>32, 'name'=>'st.statistics-theory'),
	);

}
