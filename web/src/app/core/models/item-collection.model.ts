import {Item} from "./item.model";

export class ItemCollection<T> extends Item {
  '@context': string;
  private 'hydra:member': [];
  'hydra:totalItems': number;

  constructor() {
    super();
  }

  public getItems(type: { new(): T; }): T[] {
    let items = [];

    for (let item of this['hydra:member']) {
      items.push(Object.assign(new type(), item));
    }
    return items;
  }
}
