import {Component, Inject} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import {Product, ProductService} from "@app/core";

@Component({
  selector: 'app-product-details',
  templateUrl: './product-details.component.html',
  styleUrls: ['./product-details.component.scss']
})
export class ProductDetailsComponent {

  constructor(private productService: ProductService,
              public dialogRef: MatDialogRef<ProductDetailsComponent>,
              @Inject(MAT_DIALOG_DATA) public product: Product) {
  }

  onSubmit() {
    this.productService.save(this.product).subscribe(response => {
      this.product = response;
      this.onCancel();
    });
  }

  onCancel() {
    this.dialogRef.close();
  }
}
