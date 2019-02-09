import {NgModule, Optional, SkipSelf} from '@angular/core';
import {HttpClientModule, HTTP_INTERCEPTORS} from '@angular/common/http';

import {AuthGuard} from './guards/auth.guard';

import {NgxSpinnerModule} from 'ngx-spinner';

import {TokenInterceptor} from './interceptors/token.interceptor';

import {throwIfAlreadyLoaded} from './guards/module-import.guard';

@NgModule({
  imports: [
    HttpClientModule,
    NgxSpinnerModule
  ],
  providers: [
    AuthGuard,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptor,
      multi: true
    }
  ]
})
export class CoreModule {
  constructor(@Optional() @SkipSelf() parentModule: CoreModule) {
    throwIfAlreadyLoaded(parentModule, 'CoreModule');
  }
}
