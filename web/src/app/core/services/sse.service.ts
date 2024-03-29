import {Injectable} from '@angular/core';
import {environment as env} from "../../../environments/environment";
import {Observable} from 'rxjs';
import { EventSourcePolyfill } from 'event-source-polyfill';

const SSE_BASE_URL = env.sseServerUrl;
const API_BASE_URL = env.apiServerUrl;
const SSE_JWT = env.sseServerJWT;

@Injectable({
  providedIn: 'root'
})
export class SseService {
  private topics: {[key: string]: Observable<any>} = {};

  public createSubsriber (topic: string): Observable<any> {

    if (this.topics[topic]) {
      return this.topics[topic];
    }

    const subscribeURL = new URL(SSE_BASE_URL);
    subscribeURL.searchParams.append('topic', API_BASE_URL + topic);
    const observable = new Observable<any>(observer => {
      const eventSource: EventSourcePolyfill = new EventSourcePolyfill (subscribeURL + '', {
        headers: {
          'Authorization': 'Bearer '+ SSE_JWT,
        },
        heartbeatTimeout: 120000,
      });
      eventSource.onmessage = x => observer.next(JSON.parse(x.data));
      eventSource.onerror = x => observer.error(x);

      return () => {
        eventSource.close();
      };
    });

    this.topics[topic] = observable;

    return observable;
  }
}
