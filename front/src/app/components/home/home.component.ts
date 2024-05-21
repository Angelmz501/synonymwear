import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  products = [
    { name: 'Balaclava Hoodie', price: '69,00', image: '..\..\..\assets\images\sudadera1.png' },
    { name: 'Nightclub Cap', price: '20,00', image: 'path-to-image2.jpg' },
    { name: 'Pornstar Jeans', price: '55,00', image: 'path-to-image3.jpg' },
    { name: 'We Are All Pornstars T-Shirt', price: '30,00', image: 'path-to-image4.jpg' },
    { name: 'Pornstar T-Shirt', price: '25,00', image: 'path-to-image5.jpg' },
  ];

  constructor() { }

  ngOnInit(): void {
  }
}


// import { Component, OnInit, OnDestroy } from '@angular/core';
// import { ProductosService } from '../../services/productos.service';
// import { Producto } from '../../models/producto';

// const ROWS_HEIGHT: { [id: number]: number } = { 1: 400, 3: 335, 4: 350 };

// @Component({
//   selector: 'app-home',
//   templateUrl: './home.component.html'
// })
// export class HomeComponent implements OnInit {
//   cols = 3;
//   rowHeight: number = ROWS_HEIGHT[this.cols];
//   count = '12';
//   sort = 'desc';

//   public categoria: string | undefined;
//   public productos: Array<Producto> | undefined;

//   constructor(private productosService: ProductosService) {}

//   async ngOnInit(): Promise<void> {
//     this.getProductos();
//   }

//   async getProductos() {
//     try {
//       this.productos = await this.productosService.getProducts();
//       console.log('Productos: ', this.productos);

//     } catch (error) {
//       console.error('Error al obtener los productos:', error);
//     }
//   }

//   onShowCategory(categoria: string): void {
//     this.categoria = categoria;
//     this.getProductos();
//   }
// }
