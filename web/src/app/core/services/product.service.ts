import {Injectable} from '@angular/core';

import {Observable} from 'rxjs';

import {ApiService} from './api.service';
import {Product, ItemCollection} from "../models";


const routes = {
  products: '/products',
  product: (id: number) => `/products/${id}`
};


@Injectable({
  providedIn: 'root'
})
export class ProductService {

  constructor(private apiService: ApiService) {
  }

  getAll(): Observable<ItemCollection<Product>> {
    return this.apiService.getList(routes.products);
  }

  get(id: number): Observable<Product> {
    return this.apiService.get(routes.product(id));
  }
}
