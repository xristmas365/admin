const body = document.querySelector('body');

export const breakpoints = {
  xs: 0,
  sm: 576,
  md: 768,
  lg: 992,
  xl: 1400,
};

export const createBackdrop = () => {
  const backdrop = document.createElement('div');
  backdrop.classList.add('backdrop');
  if (window.innerWidth <= breakpoints.md) {
    body.style.overflow = 'hidden';
  }
  body.appendChild(backdrop);

  return backdrop;
};

export const removeBackdrop = () => {
  document.querySelector('.backdrop').remove();
  if (window.innerWidth <= breakpoints.md) {
    body.style.overflow = 'auto';
  }
};


// CART

const $add = $('.add');
const $remove = $('.remove');

$add.click(function () {
  const $input = $(this).closest('.js-product-qty').find('input');
  $input.val($input.val() * 1 + 1);
});

$remove.click(function () {
  const $input = $(this).closest('.js-product-qty').find('input');
  const val = $input.val() * 1;
  if (val > 1) {
    $input.val(val - 1);
  }
})
