import {Component, OnInit} from '@angular/core';

import {AuthService, User} from "../../core";
import {Observable} from "rxjs";

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent implements OnInit {
  hideSxMenuItems: boolean;
  title: string;
  user: Observable<User>;


  constructor(private authService: AuthService) {
    this.hideSxMenuItems = true;
    //@TODO replace to config
    this.title = 'Web app boilerplate';
  }

  ngOnInit() {
    this.user = this.authService.currentUser;
  }

  public logout() {
    this.authService.logout();
    window.location.reload();
  }

}
