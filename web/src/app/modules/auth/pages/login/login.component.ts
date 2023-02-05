import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {tap, delay, finalize, catchError} from 'rxjs/operators';
import {of} from 'rxjs';

import {AuthService, AUTH_RETURN_URL} from '../../../../core';
import {MatSnackBar} from "@angular/material/snack-bar";

const SUCCESS_REDIRECT_URL = '/';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  error: string;
  loginForm: FormGroup;
  redirectUrl: string;

  email = new FormControl('', [Validators.required, Validators.email]);
  password = new FormControl('', [Validators.required]);


  constructor(private formBuilder: FormBuilder,
              private router: Router,
              private route: ActivatedRoute,
              private authService: AuthService,
              private snackBar: MatSnackBar) {
  }

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      this.redirectUrl = SUCCESS_REDIRECT_URL;
      if (params[AUTH_RETURN_URL]) {
        this.redirectUrl = params[AUTH_RETURN_URL];
      }
    });
  }

  login() {
    this.authService.login(this.email.value || '', this.password.value || '')
      .pipe(
        tap(user => this.router.navigate([this.redirectUrl])),
        catchError(error => of(this.openSnackBar(error.message, '')))
      ).subscribe();
  }

  private openSnackBar(message: string, action: string) {
    this.snackBar.open(message, action, {
      duration: 2000,
    });
  }

}
