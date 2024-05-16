import { Component, OnInit, OnDestroy } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { Producto } from '../../models/producto';

const ROWS_HEIGHT: { [id: number]: number } = { 1: 400, 3: 335, 4: 350 };

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
  cols = 3;
  rowHeight: number = ROWS_HEIGHT[this.cols];
  count = '12';
  sort = 'desc';

  public categoria: string | undefined;
  public productos: Array<Producto> | undefined;

  constructor(private productosService: ProductosService) {}

  async ngOnInit(): Promise<void> {
    this.getProductos();
  }

  async getProductos() {
    try {
      this.productos = await this.productosService.getProducts();
      console.log('Productos: ', this.productos);

    } catch (error) {
      console.error('Error al obtener los productos:', error);
    }
  }

  onShowCategory(categoria: string): void {
    this.categoria = categoria;
    this.getProductos();
  }
}
