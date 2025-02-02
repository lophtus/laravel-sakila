export type EntityIdentifier = number | string;

export type Identity  = {
  id: EntityIdentifier,
}

export type Address = {
  address: string,
  address2?: string,
  city: string,
  state: string,
  country: string,
  postal_code: string,
}

export type ContactInfo = {
  email?: string,
  phone: string,
}

export type Person = {
  first_name: string,
  last_name: string,
}

export type PersonWithDefaults = {
  [K in keyof Person]?: Person[K];
}

export type Actor = Identity & Person;

export type Customer = Identity & Person & Address & ContactInfo;

export type CustomerWithDefaults = {
  [K in keyof Customer]?: Customer[K];
}

export type Film = Identity & {
  title: string,
  description: string,
  language: string,
  original_language: string,
  length: number,
  rating: string,
  release_year: number,
  rental_duration: number,
  rental_rate: number,
  replacement_cost: number,
  special_features?: string,
}

export type FilmWithDefaults = {
  [K in keyof Film]?: Film[K];
}

export type Store = Identity & Address & {
  phone: string,
};

export type StoreWithDefaults = {
  [K in keyof Store]?: Store[K];
}

export type Inventory = Identity & {
  film?: Film,
  store?: Store,
}

export type InventoryWithDefaults = {
  [K in keyof Inventory]?: Inventory[K];
}
