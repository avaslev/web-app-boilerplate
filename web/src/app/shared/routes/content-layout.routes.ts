import {Routes} from '@angular/router';
import {AuthLayoutComponent} from "../../layouts/auth-layout/auth-layout.component";

export const CONTENT_ROUTES: Routes = [
    {
    path: '',
    loadChildren: () => import('../../modules/home/home.module').then(mod => mod.HomeModule)
  },
];
