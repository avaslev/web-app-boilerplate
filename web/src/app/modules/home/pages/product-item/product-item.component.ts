import {Component, Input, OnInit} from '@angular/core';
import {Product} from "@app/core";
import {AbstractProductComponent} from "../../abstract.product.component";
import {MatDialog} from "@angular/material";

@Component({
  selector: 'app-product-item',
  templateUrl: './product-item.component.html',
  styleUrls: ['./product-item.component.scss'],
})
export class ProductItemComponent extends AbstractProductComponent implements OnInit {
  @Input() product: Product;

  constructor(public dialog: MatDialog) {
    super(dialog);
  }

  ngOnInit() {
  }

}
