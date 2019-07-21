import {Injectable} from '@angular/core';
import {environment as env} from 'environments/environment';
import {Observable, throwError} from 'rxjs';

const SSE_BASE_URL = env.sseServerUrl;
const API_BASE_URL = env.apiServerUrl;

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
      const eventSource = new EventSource(subscribeURL + '');
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
