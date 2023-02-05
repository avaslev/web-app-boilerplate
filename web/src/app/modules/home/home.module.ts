import {NgModule} from '@angular/core';

import {HomeComponent} from './pages/home.component';
import {HomeRoutingModule} from './home.routing';

import {SharedModule} from '../../shared';
import {ProductItemComponent} from './pages/product-item/product-item.component';
import {ProductDetailsComponent} from './pages/product-details/product-details.component';
import {MatDialog} from "@angular/material/dialog";
import {ProductService} from "../../core";

@NgModule({
  declarations: [
    HomeComponent,
    ProductItemComponent,
    ProductDetailsComponent,
  ],
  imports: [
    SharedModule,
    HomeRoutingModule,
  ],
  exports: [],
  providers: [
    ProductService,
  ],
  entryComponents: [
    // ProductDetailsComponent,
  ],
})
export class HomeModule {
}
