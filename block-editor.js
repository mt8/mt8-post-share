const { registerPlugin } = wp.plugins;
const { PluginPostStatusInfo } = wp.editPost;
const { createElement } = wp.element;
const { PanelBody } = wp.components;

const mt8PostShare = () => {
  const { getEditedPostAttribute, isCurrentPostPublished } = wp.data.select('core/editor');

  if (!isCurrentPostPublished()) {
    return null;
  }

  const postUrl = getEditedPostAttribute('link');
  const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postUrl)}`;
  const twitterUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(postUrl)}`;

  return (
    <PanelBody title="MT8 Post Share" initialOpen={true}>
      <p>
        <a href={facebookUrl} target="_blank" rel="noopener noreferrer">
          Share on Facebook
        </a>
      </p>
      <p>
        <a href={twitterUrl} target="_blank" rel="noopener noreferrer">
          Share on Twitter
        </a>
      </p>
    </PanelBody>
  );
};

registerPlugin('mt8-post-share', {
  render: mt8PostShare,
});
