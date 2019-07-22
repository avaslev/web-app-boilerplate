import {Injectable} from '@angular/core';

import {Observable} from 'rxjs';

import {ApiService} from './api.service';
import {Product, ItemCollection} from "../models";
import {SseService} from './sse.service';


const routes = {
  products: '/products',
  product: (id: number) => `/products/${id}`
};


@Injectable({
  providedIn: 'root'
})
export class ProductService {

  constructor(private apiService: ApiService, private sseService: SseService) {
  }

  getAll(): Observable<ItemCollection<Product>> {
    return this.apiService.getList(routes.products);
  }

  get(id: number): Observable<Product> {
    return this.apiService.get(routes.product(id));
  }

  save(product: Product): Observable<Product> {
    if (product.id) {
      return this.apiService.put(routes.product(product.id), product);
    }
    return this.apiService.post(routes.products, product);
  }

  createSubscriber(topic: string): Observable<Product> {
    return this.sseService.createSubsriber(topic);
  }
}
