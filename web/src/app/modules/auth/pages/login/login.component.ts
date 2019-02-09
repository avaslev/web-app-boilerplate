import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {tap, delay, finalize, catchError} from 'rxjs/operators';
import {of} from 'rxjs';

import {AuthService, AUTH_RETURN_URL} from '@app/core';
import {MatSnackBar} from "@angular/material";

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


  constructor(private formBuilder: FormBuilder,
              private router: Router,
              private route: ActivatedRoute,
              private authService: AuthService,
              private snackBar: MatSnackBar) {
    this.buildForm();
  }

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      this.redirectUrl = SUCCESS_REDIRECT_URL;
      if (params[AUTH_RETURN_URL]) {
        this.redirectUrl = params[AUTH_RETURN_URL];
      }
    });
  }

  get email() {
    return this.loginForm.get('email');
  }

  get password() {
    return this.loginForm.get('password');
  }

  login() {
    const credentials = this.loginForm.value;

    this.authService.login(credentials.email, credentials.password)
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

  private buildForm(): void {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }
}
