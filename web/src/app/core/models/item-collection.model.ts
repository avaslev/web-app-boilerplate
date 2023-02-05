import {Item} from "./item.model";

export class ItemCollection<T> extends Item {
  '@context': string;
  private 'hydra:member': [];
  'hydra:totalItems': number;

  constructor() {
    super();
  }

  public getItems(): T[] {
    let items:any[] = [];

    for (let item of this['hydra:member']) {
      let objectItem:T = item;
      items.push(objectItem);
    }
    return items;
  }
}
