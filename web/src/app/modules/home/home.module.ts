import {NgModule} from '@angular/core';

import {HomeComponent} from './pages/home.component';
import {HomeRoutingModule} from './home.routing';

import {SharedModule} from '@app/shared';
import {ProductItemComponent} from './pages/product-item/product-item.component';

@NgModule({
  declarations: [
    HomeComponent,
    ProductItemComponent,
  ],
  imports: [
    SharedModule,

    HomeRoutingModule
  ],
  exports: [],
  providers: [],
})
export class HomeModule {
}
