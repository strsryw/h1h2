/*
  --- menu level scope settins structure --- 
  note that this structure has changed its format since previous version.
  Now this structure has the same layout as Tigra Menu GOLD.
  Format description can be found in product documentation.
*/
var MENU_POS = [{
	// ukuran menu utama
	'height': 20,
	'width': 112,
	// menu block offset from the origin:
	//	untuk menu utama, adalah jarak menu dengan kiri-atas halaman
	//	untuk menu level lain, adalah jarak menu dengan kiri-atas menu induknya
	'block_top': 0,
	'block_left': 0,
	// offsets antara item dalam 1 level
	'top': 0,
	'left': 112,
	// time in milliseconds before menu is hidden after cursor has gone out
	// of any items
	'hide_delay': 200,
	'expd_delay': 200,
	'css' : {
		'outer' : ['m0l0oout', 'm0l0oover'],
		'inner' : ['m0l0iout', 'm0l0iover']
	}
},{
	//menu dibawah root [menu keluar kebawah]
	'height': 20,
	'width': 200,
	'block_top': 21,
	'block_left': 0,
	'top': 20,
	'left': 0,
	'css' : {
		'outer' : ['m0l1oout', 'm0l1oover'],
		'inner' : ['m0l1iout', 'm0l1iover']
	}
},{
	//menu level selanjutnya [keluar disamping], menu level setelah ini akan mengikuti terus
	'block_top': 5,
	'block_left': 195
}
]
