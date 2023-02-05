import {Component, OnInit} from '@angular/core';
import {Product, ProductService} from "../../../core";
import {AbstractProductComponent} from "../abstract.product.component";
import {MatDialog} from "@angular/material/dialog";
import {MatSnackBar} from "@angular/material/snack-bar";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  providers: [ProductService],
})
export class HomeComponent extends AbstractProductComponent implements OnInit {

  products: Product[] = [];

  constructor(private productService: ProductService, public override dialog: MatDialog, private snackBar: MatSnackBar) {
    super(dialog);
  }

  ngOnInit(): void {
    this.loadProducts();
    this.createSubscriber();
  }

  loadProducts() {
    this.productService.getAll()
      .subscribe(list => {
          this.products = list.getItems().reverse();
        }
      );
  }

  createSubscriber() {
    this.productService.createSubscriber('/products/{id}')
      .subscribe(product => {
        let productList: Product[] = [];
        let action:string = 'created';
        this.products.forEach(productItem => {
          if (productItem.id == product.id) {
            action = "updated";
            productList.push(product);
            return
          }
          productList.push(productItem);
        });

        if (action == 'created') {
          productList.unshift(product);
        }

        this.products = productList;

        this.snackBar.open('Product ' + product.id + ' ' + action, null!, {
          duration: 2000,
        });
      });
  }
}
