import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {ProjectResolver} from './project-resolver.service';
import {HomeComponent} from './pages/home.component';
import {ProjectDetailsComponent} from './pages/project-details/project-details.component';

export const routes: Routes = [
  {
    path: '',
    component: HomeComponent
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomeRoutingModule {
}
