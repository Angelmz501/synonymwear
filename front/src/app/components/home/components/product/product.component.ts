import { Component, EventEmitter, Input, Output } from '@angular/core';
import { Producto } from '../../../../models/producto';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
})
export class ProductComponent {
  @Input() fullWidthMode = false;
  @Input() producto: Producto | undefined;
  @Output() addCarrito = new EventEmitter();

  onAddToCart(): void {
    this.addCarrito.emit(this.producto);
  }

}
