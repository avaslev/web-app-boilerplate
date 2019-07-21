import {Component, OnInit} from '@angular/core';
import {map} from "rxjs/operators";
import {ItemCollection, Product, ProductService} from "@app/core";
import {MatDialog, MatSnackBar} from "@angular/material";
import {AbstractProductComponent} from "@app/modules/home/abstract.product.component";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent extends AbstractProductComponent implements OnInit {

  products: Product[];

  constructor(private productService: ProductService, public dialog: MatDialog, private snackBar: MatSnackBar) {
    super(dialog);
  }

  ngOnInit(): void {
    this.loadProducts();
    this.createSubscriber();
  }

  loadProducts() {
    this.productService.getAll()
      .pipe(
        map(data => Object.assign(new ItemCollection<Product>(), data))
      )
      .subscribe(productCollection => {
          this.products = productCollection.getItems(Product);
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
          productList.push(product);
        }

        this.products = productList;

        this.snackBar.open('Product ' + product.id + ' ' + action, null, {
          duration: 2000,
        });
      });
  }
}
