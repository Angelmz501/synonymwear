import {
  Component,
  EventEmitter,
  OnDestroy,
  OnInit,
  Output,
} from '@angular/core';
import { ProductosService } from '../../../../services/productos.service';

@Component({
  selector: 'app-filtros',
  templateUrl: './filtros.component.html',
})
export class FiltrosComponent implements OnInit {
  @Output() showCategory = new EventEmitter<string>();

  public categorias: any[] | undefined;

  constructor(private productosService: ProductosService) {}

  async ngOnInit(): Promise<void> {
    this.categorias = await this.productosService.getCategorias();

    console.log('categorias:', this.categorias);
  }

  onShowCategory(category: string): void {
    this.showCategory.next(category);
  }
}
