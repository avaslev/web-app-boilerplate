import {Injectable} from '@angular/core';
import {of, Observable, throwError, BehaviorSubject} from 'rxjs';

import {User} from '../models/user.model';
import {HttpClient} from "@angular/common/http";
import {environment as env} from "environments/environment";
import {ApiService} from "./api.service";
import {catchError, map} from "rxjs/operators";

const BASE_URL = env.authServerUrl;

@Injectable({
  providedIn: 'root'
})
export class AuthService extends ApiService {
  private currentUserSubject: BehaviorSubject<User>;
  public currentUser: Observable<User>;

  constructor(protected httpClient: HttpClient) {
    super(httpClient);
    this.currentUserSubject = new BehaviorSubject<User>(JSON.parse(localStorage.getItem('currentUser')));
    this.currentUser = this.currentUserSubject.asObservable();
  }

  public get currentUserValue(): User {
    return this.currentUserSubject.value;
  }


  logout() {
    // remove user from local storage to log user out
    localStorage.removeItem('currentUser');
    this.currentUserSubject.next(null);
  }

  login(username: string, password: string): Observable<User> {
    return this.httpClient.post<any>(BASE_URL + '/login', {email: username, password: password})
      .pipe(
        map(user => {
          // login successful if there's a jwt token in the response
          if (user && user.token) {
            // store user details and jwt token in local storage to keep user logged in between page refreshes
            localStorage.setItem('currentUser', JSON.stringify(user));
            this.currentUserSubject.next(user);
          }
          return user;
        }),
        catchError(this.formatErrors)
      );
  }
}
