import {ChangeDetectionStrategy, Component, Input, OnInit} from '@angular/core';
import {Product, ProductService} from "../../../../core";
import {AbstractProductComponent} from "../../abstract.product.component";
import {MatDialog} from "@angular/material/dialog";

@Component({
  selector: 'app-product-item',
  templateUrl: './product-item.component.html',
  styleUrls: ['./product-item.component.scss'],
  providers: [MatDialog],
})
export class ProductItemComponent extends AbstractProductComponent implements OnInit {
  @Input() product: Product;
  constructor(public override dialog: MatDialog) {
    super(dialog);
  }

  ngOnInit() {
  }

}
