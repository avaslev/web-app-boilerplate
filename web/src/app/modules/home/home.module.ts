import {NgModule} from '@angular/core';

import {HomeComponent} from './pages/home.component';
import {HomeRoutingModule} from './home.routing';

import {SharedModule} from '@app/shared';
import {ProductItemComponent} from './pages/product-item/product-item.component';
import {ProductDetailsComponent} from './pages/product-details/product-details.component';

@NgModule({
  declarations: [
    HomeComponent,
    ProductItemComponent,
    ProductDetailsComponent,
  ],
  imports: [
    SharedModule,

    HomeRoutingModule
  ],
  exports: [],
  providers: [],
  entryComponents: [
    ProductDetailsComponent,
  ],
})
export class HomeModule {
}
