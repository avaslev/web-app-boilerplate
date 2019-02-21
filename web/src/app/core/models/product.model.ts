import {Item} from "@app/core/models/item.model";

export class Product extends Item {
  id: number;
  name: string;
  price: number;
  media: string;
}
