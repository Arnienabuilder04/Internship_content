# Gallery Generator Manual

### Grid Size
numRowsMobile / numColsMobile → Rows & columns for mobile view.
numRowsDesktop / numColsDesktop → Rows & columns for desktop view.


### Image Transformations
offsetXEven/offsetXOdd → Changed the Offset of the images on the X-axis depending if the image is Even or Odd in the Checkerboard grid.
use in the code: offsetX = (Math.random() - 0.5) * offsetXOdd;


offsetYEven/offsetYOdd → Changed the Offset of the images on the Y-axis depending if the image is Even or Odd in the Checkerboard grid.
use in the code: offsetY = (Math.random() - 0.5) * offsetYOdd;


scaleEven/scaleOdd → Changed the Scale of the images depending if the image is Even or Odd in the Checkerboard grid.
use in the code: scale = Math.random() / scaleParam + scaleOdd;


scaleParam → Scales down the maximum amount of randomness.
use in the code: scale = Math.random() / scaleParam + scaleOdd;

So in general every image is being moved according to these variables
img.style.transform = "translate(${offsetX}%, ${offsetY}%) scale(${scale})";


### Grid Spacing
gapSize → Defines the spacing between images in the grid.
use in the code: const gapSize = "5% 5%";
