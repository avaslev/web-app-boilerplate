import {Component, OnInit} from '@angular/core';
import {map} from "rxjs/operators";
import {ItemCollection, Product, ProductService} from "@app/core";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  products: Product[];

  constructor(private productService: ProductService) {
  }

  ngOnInit(): void {
    this.loadProducts();
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
}
