import {Product} from "../../core";
import {MatDialog} from "@angular/material/dialog";
import {ProductDetailsComponent} from "./pages/product-details/product-details.component";


export abstract class AbstractProductComponent {

  constructor(public dialog: MatDialog) {
  }

  onClickEdit(product: Product): void {
    console.log(product);
    const dialogRef = this.dialog.open(ProductDetailsComponent, {
      width: '250px',
      data: product
    });
  }

  onClickCreate(): void {
    this.onClickEdit(new Product());
  }
}
