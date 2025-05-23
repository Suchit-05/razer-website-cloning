let cart = JSON.parse(localStorage.getItem('cart')) || [];

function addToCart(id, name, price) {
  const itemIndex = cart.findIndex(item => item.id === id);
  if (itemIndex > -1) {
    cart[itemIndex].quantity += 1;
  } else {
    cart.push({ id, name, price, quantity: 1 });
  }
  localStorage.setItem('cart', JSON.stringify(cart));
  alert(`${name} added to cart!`);
}

function loadCart() {
  const cartContainer = document.getElementById('cart-items');
  const totalContainer = document.getElementById('cart-total');
  if (!cartContainer) return;

  cartContainer.innerHTML = '';
  let total = 0;

  cart.forEach((item, index) => {
    const div = document.createElement('div');
    div.innerHTML = `
      <h3>${item.name}</h3>
      <p>Price: $${item.price} x ${item.quantity}</p>
      <button onclick="updateQuantity(${index}, 1)">+</button>
      <button onclick="updateQuantity(${index}, -1)">-</button>
      <button onclick="removeItem(${index})">Remove</button>
    `;
    cartContainer.appendChild(div);
    total += item.price * item.quantity;
  });

  totalContainer.textContent = `Total: $${total}`;
}

function updateQuantity(index, change) {
  cart[index].quantity += change;
  if (cart[index].quantity <= 0) cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  loadCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  loadCart();
}

document.addEventListener('DOMContentLoaded', loadCart);
