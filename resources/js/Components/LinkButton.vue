<script>
import { h } from 'vue';
export default {
  props: {
    tag: {
      default: 'a',
    },
    appearance: {
      default: 'save',
    },
    href: {
      type: String,
      default: '#',
    },
    type: {
      type: String,
      default: 'submit',
    },
    class: {
      type: String,
      default: '',
    },
  },
  render(props) {
    let classes = '';
    let label = '';
    switch (props.appearance) {
      case 'create':
        label = this.$slots.default ? this.$slots.default() : 'Novo';
        classes =
          'inline-flex items-center px-5 py-2 border border-blue-300 hover:border-blue-400 text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-50 hover:text-blue-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-100 active:bg-blue-50 transition duration-150 ease-in-out';
        break;
      case 'cancel':
        label = this.$slots.default ? this.$slots.default() : 'Alterar';
        classes = 'inline-flex items-center px-4 py-3 sm:py-2 border border-gray-300 hover:border-gray-400 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out';
        break;
      case 'edit':
        label = this.$slots.default ? this.$slots.default() : 'Alterar';
        classes = 'inline-flex items-center px-4 py-3 sm:py-2 border border-gray-200 bg-gray-100 hover:bg-gray-200 text-sm leading-5 font-medium rounded-md text-gray-700 hover:text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out';
        break;
      case 'delete':
        label = this.$slots.default ? this.$slots.default() : 'Excluir';
        classes =
          'inline-flex items-center px-4 py-3 sm:py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white hover:text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:shadow-outline-red focus:border-red-700 active:bg-red-700 transition duration-150 ease-in-out';
        break;
      default:
        // save
        label = this.$slots.default ? this.$slots.default() : 'Salvar';
        classes =
          'inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white hover:text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-700 transition duration-150 ease-in-out';
    }
    return h(
      props.tag,
      {
        class: props.class + ' ' + classes,
        href: props.href,
        type: props.type,
      },
      label
    );
  },
};
</script>