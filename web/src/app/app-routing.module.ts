import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';

import {AuthLayoutComponent} from './layouts/auth-layout/auth-layout.component';
import {ContentLayoutComponent} from './layouts/content-layout/content-layout.component';
import {NotFoundComponent} from './layouts/not-found/not-found.component';

import {CONTENT_ROUTES} from './shared';

import {AuthGuard} from './core';

const routes: Routes = [
  {
    path: '',
    pathMatch: 'full',
    redirectTo: '/products'
  },
  {
    path: '',
    component: ContentLayoutComponent,
    canActivate: [AuthGuard], // Should be replaced with actual auth guard
    children: CONTENT_ROUTES
  },
  {
    path: 'auth',
    component: AuthLayoutComponent,
    loadChildren: () => import('./modules/auth/auth.module').then(mod => mod.AuthModule)
  },
  // Fallback when no prior routes is matched
  {path: '**', component: NotFoundComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {useHash: true})],
  exports: [RouterModule],
  providers: []
})
export class AppRoutingModule {
}
