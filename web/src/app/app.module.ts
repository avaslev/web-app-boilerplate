import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {CoreModule} from './core';
import {SharedModule} from './shared';

import {AppComponent} from './app.component';
import {AppRoutingModule} from './app-routing.module';

import {ContentLayoutComponent} from './layouts/content-layout/content-layout.component';
import {NavComponent} from './layouts/nav/nav.component';
import {FooterComponent} from './layouts/footer/footer.component';

import {AuthLayoutComponent} from './layouts/auth-layout/auth-layout.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {NotFoundComponent} from './layouts/not-found/not-found.component';
import {MAT_DIALOG_DEFAULT_OPTIONS, MatDialogModule} from "@angular/material/dialog";

@NgModule({
  declarations: [
    AppComponent,
    ContentLayoutComponent,
    NavComponent,
    FooterComponent,
    AuthLayoutComponent,
    NotFoundComponent
  ],
  imports: [
    // angular
    BrowserModule,

    // 3rd party
    MatDialogModule,

    // core & shared
    CoreModule,
    SharedModule,

    // app
    AppRoutingModule,

    BrowserAnimationsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
