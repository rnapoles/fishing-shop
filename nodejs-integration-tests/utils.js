import faker from 'faker';
import { v4 as uuidv4 } from 'uuid';

const randomElement = faker.random.arrayElement;

function generateFakeProduct(){

  let purchase = faker.datatype.number({max: 20, min: 10});
  let sale = faker.datatype.number({max: 30, min: 21});

  if (purchase < 20) {
      sale = faker.datatype.number({max: purchase + 5, min: purchase + 1});
  }

  return {
    "name": faker.hacker.noun() + ' ' + faker.datatype.number({max: 1000, min: 10}),
    "purchase_price": purchase,
    "sale_price": sale,
    "units_in_stock": randomElement([1,2,3,4,5]),
  }
  
}

export default {
  generateFakeProduct
}